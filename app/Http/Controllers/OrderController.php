<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Model\User;
use App\Model\Lead;
use App\Model\Order;
use App\Model\OrderUser;
use App\Model\IndexPrice;
use App\Model\Index;
use App\Model\OrderNegotiation;
use App\Model\OrderApprovalLog;
use App\Model\OrderApprovalScheme;
use App\Model\OrderApprovalSchemeSequence;
use App\Model\Contract;
use App\Model\Role;

use Tymon\JWTAuth\Facades\JWTAuth;
use Ixudra\Curl\Facades\Curl;
use Firebase\FirebaseInterface;
use Firebase\FirebaseLib;
use Auth;

use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovalRequest;

class OrderController extends Controller
{
  public function __construct(Order $order)
  {
    $this->middleware('jwt.auth', [ 'except' => 'approval' ]);
    $this->order = $order;
  }

  //////////////////////////////////////
  //
  // REUSABLE FUNCTIONS
  // the reusable functions are designed
  // only for business logic of orders
  //
  // indexPrice       --> get the latest index price from Index database
  // combineOrder     --> function to combine two existing orders
  // funnel           --> re-routed action from index(), which displays only statistical number
  // checkAvailable   --> Check whether one lead is available to be staged to the order
  // mailApproval     --> send mail (3)
  // requestApproval  --> requests approval for single user,
  //                      calls mailApproval to send mail notifications
  // sequenceApproval --> gets approval sequence & get designated users,
  //                      calls requestApproval to add approval to designated user
  // resetApproval    --> detach all approval in an order, calls sequenceApproval after succession
  // removeUpperAppr  --> detach all pending approval in upper sequence IF 1 guy rejected
  //
  //////////////////////////////////////

  /*
   *  This is to display the indexPrice inside the orders when loaded for mobile apps
   */

  private function indexPrice () {
    $query = DB::table('index_price AS ip1')
      ->select('index.id', 'index_provider', 'index_name', 'ip1.date', 'ip1.price')
      ->join('index', 'ip1.index_id', '=', 'index.id')
      ->orderBy('index.id')
      ->join(DB::raw('(select index_id, MAX(date) AS date FROM index_price GROUP BY index_id) as ip2'),
        function($join){
          $join->on('ip1.index_id', '=', 'ip2.index_id')
            ->on('ip1.date', '=', 'ip2.date');
        });

    return $query->get();
  }

  private function combineOrder($items, $id) {
    $message = 'error';
    foreach($items as $item){
      if($item['order_status'] != 'p' && $item['order_status'] != 's') { $message = 'error'; continue; }
      else {
        $order_id = DB::table('order_details')
                    ->where('lead_id', $item['id'])
                    ->where('order_id', '!=', $id)->pluck('order_id');
        if(count($order_id) != 1) { $message = 'error'; continue; }
        else {
          $oldOrder = Order::with('leads')->find($order_id);
          if($oldOrder->leads->count() > 1) { $message = 'error'; continue; }
          else {
            if($oldOrder->status == 'a') {
              foreach($oldOrder->leads as $lead) {
                if($lead->pivot['volume'] == $item['pivot']['volume']) {
                  $oldOrder->status = 'c';
                  $oldOrder->save();
                  $message = 'success';
                }
                else { $message = 'error'; continue; }
              }
            }
            else { $message = 'error'; continue; }
          }
        }
      }
    }
    return $message;
  }

  /*
   * Instead of returning a list of order, get a funnel and number of total orders
   */
  private function funnel(){
    $order = Order::select(DB::raw('count(*) as count, status'))
      ->whereIn('status', ['p', 'a', 'f'])
      ->groupBy('status')->get();

    $lead = Lead::select(DB::raw('count(*) as count, lead_type'))
      ->whereIn('order_status',['v','l'])
      ->groupBy('lead_type');

    $funnel = [
      'pending' => 0,
      'approved' => 0,
      'finalized' => 0,
      'lead-buy' => 0,
      'lead-sell' => 0
    ];

    foreach($order as $o){
      switch($o->status){
        case 'p' : $funnel['pending'] = $o->count; break;
        case 'a' : $funnel['approved'] = $o->count; break;
        case 'f' : $funnel['finalized'] = $o->count; break;
      }
    }

    foreach($lead as $l){
      switch($l->lead_type){
        case 'b' : $funnel['lead-buy'] = $l->count; break;
        case 's' : $funnel['lead-sell'] = $l->count; break;
      }
    }

    return response()->json($funnel,200);
  }

  /**
   * Check if current order CAN stage the lead
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */

  private function checkAvailable($order, $lead){
    // If this is invoked from UPDATE, instead of using lead from params, do get its volumes from pivot
    // Get from the current volume IF this is a staging order
    if(!$lead->lead_id) $volume = $lead->pivot->volume;
    else $volume = $lead->volume;

    // Get all orders associated with this current lead to know its standing
    $lead_to_stage = Lead::with('orders')->find($lead->id);

    // get total of the used volume
    // IF THEY ARE confirmed leads
    if(count($lead_to_stage->orders)>0){
      foreach($lead_to_stage->orders as $associated_orders) {
        // exclude draft and one that is current order
        if($associated_orders->status != 'd' && $associated_orders->status != 'x' && $associated_orders->status != 'c' && $associated_orders->id != $order->id)
          $volume += $associated_orders->pivot->volume;
      }
    }

    if ($volume > $lead_to_stage->volume) {
      $order->available_volume = 'error';
    }
  }

  private function mailApproval (&$order, $approval_properties, $user) {
    // get the earliest laycan and latest one
    $order->earliestLaycan();
    $order->latestLaycan();

    // find all averages of the order details.
    $order->averageSell();
    $order->averageBuy();

    // get latest GC NEWC price
    $index = $this->indexPrice();

    $mail = new ApprovalRequest($order, $approval_properties['approval_token'], $index[0]->price);
    Mail::to($user->email)->send($mail);
  }

  private function requestApproval (&$order, $user) {
    // Add approval request to specific user

    // Add new approval request
    $approval_properties = [
      'status' => 'p',
      'approval_token' => bcrypt(date('Y-m-d H:i:s') . $user->name)
    ];
    $order->approvals()->sync([$user->id => $approval_properties], false);

    // add new associated user in the request
    $order->users()->sync([$user->id => [ 'role' => 'approver' ]], false);

    //send notif to firebase
    $manager_notification = [
      'url' => 'order/' . $order->id,
      'notification' => 'ORD #' . sprintf("%02d",$order->id) . ' is waiting for your approval',
      'created_at' => Carbon::now()->toDateTimeString(),
      'isRead' => false
    ];

    $this->saveToFirebase($manager_notification, $user->id);

    $this->mailApproval($order, $approval_properties, $user);
  }

  /* The function to send the notification to firebase
   *
   *
   @ orderId = id of the order as the notification
   @ user = user that will get the notification
   #
   */
  private function saveToFirebase($notification, $user) {
    // $response = Curl::to(config('services.firebase.database_url') . 'notification/'. $user)
    //     ->withData($notification)
    //     ->post();

    $firebaseClient = new FirebaseLib(config('services.firebase_dev.database_url'), config('services.firebase_dev.secret'));
    $path = 'notification/' . $user;
    $res = $firebaseClient->push($path, $notification);
  }

  private function getApprScheme ($order) {
      // LEVEL 1: get approval scheme by area
      $areas = [];
      foreach($order->sells as $sell) $areas[] = $sell->company->area_id; // get all area to know

      if(count(array_unique($areas)) === 1) $sell_area = $areas[0]; // if area are homogenous, go on
      else $sell_area = config('app.default_area');                 // if not, get the default area

      // NEXT LEVEL OF FILTERING GOES HERE //

      // GET THE APPROVAL SCHEME TOGETHER WITH THE SEQUENCES IT HAS
      $q = OrderApprovalScheme::with('sequences');
      if($sell_area) $q->where('sell_area_id', $sell_area); // get only approval that has sell area id specified
      // add more validation here
      $app_scheme = $q->first();

      return $app_scheme;
  }

  private function getApprSequence ($order, $app_scheme, $seq){
    $next_seq = false;
    if(!$order->approval_sequence) return $app_scheme->sequences[0];

    // GET THE ORDER'S CURRENT APPROVAL SEQUENCE
    foreach($app_scheme->sequences as $s){
      if($s->sequence == $order->approval_sequence && $seq === 'curr') return $s;
      if($s->sequence == $order->approval_sequence+1 && $seq === 'next') return $s;
      if($s->sequence+1 == $order->approval_sequence && $seq === 'prev') return $s;
    }

  }

  /* The function to find out current order's approval scheme &
   * & do appropriate next action after these 3 possible scenario:
   * 1. updating order, request first approval
   * 2. approving order, continuing approval sequence
   * 3. changing things, reset approval, re-request first approval
   *
   @ order : the order that needs to be approved
   #
   */

  private function sequenceApproval (&$order) {
    // LIST OF IMPORTANT VARIABLES:
    // * $app_scheme (Object) : the scheme of the approval, complete with its sequences
    // * $curr_seq (Object)   : current sequence of the approval that is now
    // * $next_seq (Object)   : the next sequence of the approval that is now
    // * $elevate (Bool)      : whether it passes condition to elevate the sequence

    // get Approval Scheme
    $app_scheme = $this->getApprScheme($order);
    $curr_seq = $this->getApprSequence($order, $app_scheme, 'curr');
    $next_seq = $this->getApprSequence($order, $app_scheme, 'next');

    // find out whether or not this order fulfills condition of current sequence
    // $curr_seq is the current sequence of approval which has all the necessary rules
    $elevate = false;
    $count_approvers = $curr_seq->approval_scheme; // by default, number of approver is defined by approval_scheme attribute
                                                   // this is only changed IF case is A. but overall logic is matching the count
    $count_actual_approved = 0;
    $count_requested_approvers = 0;

    switch($curr_seq->approval_scheme){
      case 'd' :
      case 'o' : // approval scheme 'OR' or 'DIRECT SUPERVISOR', 1 guy ok and pass
        $count_approvers = 1;
        break;

      case 'a' : // get all users with such role, and make sure count is correct
        $approver_role = Role::with('users')->find($curr_seq->role_id);
        $count_approvers = count($approver_role->users);
        break;
    }

    foreach($order->approvals as $a){
      $count_requested_approvers++;
      if($a->pivot->status == 'a') {
        foreach($a->roles as $r)
          if($r->id == $curr_seq->role_id) $count_actual_approved++;
      }
    }

    // find out whether or not this order require next sequence of approval
    // if true, elevate the sequence
    if(is_numeric($count_approvers) && $count_actual_approved >= $count_approvers){
      $elevate = true;

      // in case this qualifies for elevation, mark other approval as auto-approved
      foreach($order->approvals as $a)
        if($a->pivot->status == 'p')
          foreach($a->roles as $r)
            if($r->id == $curr_seq->role_id)
              $order->approvals()->sync([$a->id => ['status' => 'y']], false);
    }

    // in case where approvals are nonexistent, add new ones
    if(!$count_requested_approvers && $order->approval_sequence){
      $elevate = true;
      $next_seq = $curr_seq;
    }

    // send approval to each users. add the database & send the email
    // do nothing if no elevation needed
    if($elevate || !$order->approval_sequence){
      if($next_seq){
        // if there's a next sequence, request for approval
        $order->approval_sequence = $next_seq->sequence;
        $order->save();

        if($next_seq->approval_scheme === 'd'){
          // if the next sequence is asking for a direct supervisor, typically you will simply add manager_id from user
          // but before that, do a check whether user's direct supervisor is in the correct role.
          // assume everyone approved if direct supervisor is not in that list
          $found = false;
          $supervisor = Auth::user();

          // get supervisor/manager with correct role
          do {
            $supervisor = User::with('roles')->find(Auth::user()->manager_id);

            if($supervisor == null) break;
            else{
              foreach($supervisor->roles as $r){
                if($r->id == $next_seq->role_id){
                  $found = true; break;
                }
              }
            }
          } while (!$found && $supervisor);

          // IF FOUND, request the approval from that supervisor
          if($found) $this->requestApproval($order, $supervisor);
          else {
            // however, if not found, add the sequence, redo the approval sequence check
            $order->status = $next_seq->sequence + 1;
            $order->save();

            $this->sequenceApproval($order);
          }
        } else {
          // else, request approval from ALL guys in that role
          $approver_role = Role::with('users')->find($next_seq->role_id);

          foreach($approver_role->users as $approver)
            $this->requestApproval($order, $approver);
        }
      } else {
        // without next sequence, this is the last sequence of the scheme
        // which means, the order status will be rendered 'a' (approved)
        $order->status = 'a';
        $order->save();
      }
    }

    return true;
  }

  public function resetApproval(&$order){
    $order->approvals()->detach();

    $this->sequenceApproval($order);
  }

  private function removeUpperAppr(&$order){
    $app_scheme = $this->getApprScheme($order);
    $curr_seq = $this->getApprSequence($order, $app_scheme, 'curr');
    $prev_seq = $this->getApprSequence($order, $app_scheme, 'prev');

    // in the case where this approval is rejected,
    // add the other approval status into 'n' (auto-reject)
    foreach($order->approvals as $a)
      if($a->pivot->status == 'p')
        foreach($a->roles as $r)
          if($r->id == $curr_seq->role_id)
            $order->approvals()->sync([$a->id => ['status' => 'n']], false);
  }

  //////////////////////////////////////
  //
  // COMMON CRUD ACTIONS
  // common create-read-update-delete
  // operations for RESTful API
  //
  // index / store / show / update / destroy
  // approval --> manage the approval status of current user towards the order
  // stage    --> stage one lead to the order
  //
  //////////////////////////////////////

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $req)
  {
    if($req->funnel == true) return $this->funnel();

    //DB::enableQueryLog();
    $orders = Order::with('trader', 'approvals','users');

    if($req->status != '') $orders = $orders->where('status', $req->status);

    if($req->q) $param = $req->q; else $param = '';

    if($req->category == 'subordinates'){
      $subs = Auth::user()->subordinates();

      $users = $subs->pluck('id')->all();
      $orders->whereIn('user_id', $users);

      /*$orders->whereHas('trader', function ($query) use ($req){
        $query->where('name', 'like', '%'.$req->q.'%');
      });*/
    }
    else if($req->category == 'associated'){
      $orders->whereHas('users', function($query) use ($req){
        $query->where('user_id', Auth::user()->id);
        //$query->where('name', 'like', '%'.$req->q.'%');
      });
      /*if($req->q){
        $param = $req->q;
                  $query->orwhereHas('name LIKE "%'.$param.'%"');
      }*/
    }
    else if($req->category == 'approval'){
      $orders->whereHas('approvals', function ($query) use ($req){
        $query->where('users.id', Auth::user()->id);
        //$query->where('name', 'like', '%'.$req->q.'%');

        if($req->approval_status){
          $query->where('order_approvals.status', substr($req->approval_status,0,1));
        }

      });

    }
    else{
      $orders->whereHas('trader', function($query) use ($req){
        $query->where('id', Auth::user()->id);
      });
    }

    $orders->whereHas('trader', function ($query) use ($req){
      $query->where('name', 'like', '%'.$req->q.'%');
    });

    //var_dump($orders->toSql());

    //limit order
    if (!$req->limit) $req->limit = 50;
    $orders->limit($req->limit);

    $orders = $orders->get();


    if($req->category == 'approval'){
      $orders = $orders->each(function ($item, $key) {
        foreach($item->approvals as $approval){
          if($approval->id === Auth::user()->id){
            $item->approval_status = $approval->pivot->status;
          }
        }
      });
    }

    if($req->envelope)
      $orders = [
        'status' => 200,
        'error' => 'ok',
        'orders' => $orders
      ];

    return response()->json($orders, 200);
  }

  /**
   * Store a newly created resource in storage.
   * Since the resource are creted in "draft" status
   * this acts as a dumb door to simply add value
   *
   * @param  \Illuminate\Http\Request  $req
   * @return \Illuminate\Http\Response
   */
  public function store(Request $req)
  {
    // Check the availability of volume lead
    if(count($req->buys) > 0){
      foreach($req->buys as $buy){
        $used = 0;
        foreach($buy['used'] as $use){
          $used += $use['volume'];
        }
        if ($buy['pivot']['volume'] > ($buy['volume'] - $used)) return response()->json([ 'message' => 'Bad Request in buy pivot volume' ], 400);
      }
    }
    if(count($req->sells) > 0){
      foreach($req->sells as $sell){
        $used = 0;
        foreach($sell['used'] as $use){
          $used += $use['volume'];
        }
        if ($sell['pivot']['volume'] > ($sell['volume'] - $used)) return response()->json([ 'message' => 'Bad Request in sell pivot volume' ], 400);
      }
    }

    if(!$req) {
      return response()->json([
        'message' => 'Bad Request'
      ], 400);
    }

    $order = new Order();
    $order->user_id = Auth::User()->id;
    $order->index_id = $req->index_id;
    $order->status = 'd';
    $order->save();

    //add user as the admin for the current order
    $order->users()->attach([ $order->user_id => [ 'role' => 'admin' ]]);

    // Check the availability of associated leads
    if(count($req->buys) > 0 && !$req->in_house){
      foreach($req->buys as $buy){
        $order->buys()->attach([ $buy['id'] => $buy['pivot'] ]);
        // Lead::find($buy['id'])->reconcile();

        // add negotiation log to the staged lead
        $order_detail_id = $order->buys()->find($buy['id'])->pivot->id;

        OrderNegotiation::create([
          'order_detail_id' => $order_detail_id,
          'notes' => 'Initial Deal',
          'volume' => $buy['pivot']['volume'],
          'base_currency_id' => $buy['pivot']['base_currency_id'],
          'base_price' => $buy['pivot']['base_price'],
          'deal_currency_id' => $buy['pivot']['deal_currency_id'],
          'deal_price' => $buy['pivot']['deal_price'],
          'exchange_rate' => $buy['pivot']['exchange_rate'],
          'trading_term' => $buy['pivot']['trading_term'],
          'payment_term' => $buy['pivot']['payment_term'],
          'user_id' => Auth::user()->id,
        ]);
      }
    }
    if(count($req->sells) > 0) {
      foreach($req->sells as $sell){
        $order->sells()->attach([ $sell['id'] => $sell['pivot'] ]);
        Lead::find($sell['id'])->reconcile();

        // add negotiation log to the staged lead
        $order_detail_id = $order->sells()->find($sell['id'])->pivot->id;

        // $order_detail = $order->orders->find($sell['id']);
        OrderNegotiation::create([
          'order_detail_id' => $order_detail_id,
          'notes' => 'Initial Deal',
          'volume' => $sell['pivot']['volume'],
          'base_currency_id' => $sell['pivot']['base_currency_id'],
          'base_price' => $sell['pivot']['base_price'],
          'deal_currency_id' => $sell['pivot']['deal_currency_id'],
          'deal_price' => $sell['pivot']['deal_price'],
          'exchange_rate' => $sell['pivot']['exchange_rate'],
          'trading_term' => $sell['pivot']['trading_term'],
          'payment_term' => $sell['pivot']['payment_term'],
          'user_id' => Auth::user()->id,
        ]);
      }
    }
    $order->addAdditionalCosts($req->additional);

    $leads_notification = [
      'url' => 'order/' . $order->id,
      'notification' => 'ORD #' . sprintf("%02d",$order->id) . ' used your leads',
      'created_at' => Carbon::now()->toDateTimeString(),
      'isRead' => false
    ];

    foreach ($req->sells as $s) {
      $manager = User::where('id', $s['user_id'])->pluck('manager_id');
      $this->saveToFirebase($leads_notification, $s['user_id']);
      $this->saveToFirebase($leads_notification, $manager);
    }

    foreach ($req->buys as $b) {
      $manager = User::where('id', $b['user_id'])->pluck('manager_id');
      $this->saveToFirebase($leads_notification, $b['user_id']);
      $this->saveToFirebase($leads_notification, $manager);
    }

    return response()->json($order, 200);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id, Request $req = null)
  {
    $order = Order::with(['trader', 'users', 'sells', 'buys',
        'buys.trader', 'sells.trader',
        'approvals', 'approvals.roles', 'approvalLogs', 'companies',
        'sells.company', 'buys.company', 'sells.factory', 'contracts',
        'buys.concession' => function ($q) {
          return $q->select('concession_name');
        }
      ])->find($id);

    $this->authorize('view', $order);

    // lazyloading semua negotiation log
    $order->getNegotiations();

    // get the earliest laycan and latest one
    $order->earliestLaycan();
    $order->latestLaycan();

    // find all averages of the order details.
    $order->averageSell();
    $order->averageBuy();

    if (isset($req)) {
      // IF envelope is requested, get all necessary components
      if($req->envelope == "true"){
        // dd($req);
        $index = $this->indexPrice();

        $json = [
          'status' => 200,
          'error' => 'ok',
          'order' => $order,
          'index' => $index
        ];
      } else $json = $order;
    } else $json = $order;

    return response()->json($json, 200);
  }


  /**
   * edit the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */

  public function update(Request $req, $id)
  {
    $order = Order::with('buys','sells')->find($id);

    // Validations
    if(!$req) return response()->json([ 'message' => 'Bad Request' ], 400);
    if (!$order) return response()->json([ 'message' => 'Not found' ] ,404);

    // Only the owner of the order can change anything
    if ($order->user_id != Auth::user()->id) return response()->json([ 'message' => 'You are not authorized to edit this order!' ] ,403);
    // In-house product can only be used in Sell-Only Orders
    if ($req->in_house && count($order->buys)) return response()->json([ 'message' => 'In-house product can only in sell-only Order' ] ,400);

    $this->authorize('update', $order);

    // Reconcile the statuses of each leads
    if(count($order->buys) > 0){
      foreach($order->buys as $buy){
        $this->checkAvailable($order, $buy);
        Lead::find($buy['id'])->reconcile();
      }
    }
    if(count($order->sells) > 0) {
      foreach($order->sells as $sell){
        $this->checkAvailable($order, $sell);
        Lead::find($sell['id'])->reconcile();
      }
    }

    // Check available volume
    if ($order->available_volume === 'error') {
      return response()->json([ 'message' => 'Volume not avaliable' ], 400);
    }

    if(count($req->buys) > 0 && !$req->in_house) {
      $message = $this->combineOrder($req->buys, $id);
    }

    if(count($req->sells) > 0) {
      $message = $this->combineOrder($req->sells, $id);
    }


    $order->index_id = $req->index_id;
    $order->request_reason = $req->request_reason;
    $order->finalize_reason = $req->finalize_reason;
    $order->cancel_reason = $req->cancel_reason;
    $order->in_house = $req->in_house;
    $order->status = $req->status;
    $order->save();

    // Add new additional cost in the application
    $order->addAdditionalCosts($req->additional);

    // If this is a delete operation, release all partials
    if($order->status == 'x'){
      $order->leadToPartial();
    } else if($order->status == 'p') {
      // begin/continue approval sequence
      $this->sequenceApproval($order);
    }

    return $this->show($id, $req);
  }



  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $order = Order::with('trader', 'approvals')->find($id);
    $order->status = 'x';
    $order->leadToPartial();

    $order->save();

    return response()->json($order, 200);
  }

  /**
   * Set the status of approval of an order
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function approval(Request $req, $id)
  {
    $order = Order::with( 'approvals', 'approvals.roles',
      'sells', 'sells.trader', 'sells.company',
      'buys', 'buys.trader', 'buys.company')->find($id);

    // since approval does not use jwt middleware,
    // we need to try whether they are using approval token
    // or using the JWT token.

    // if using token, get the specified approving user
    if($req->approval_token) $user = $order->getApproverByToken($req->approval_token);
    else {  // or simply load the user if using Auth only.
      $user = JWTAuth::parseToken()->authenticate();
      $this->authorize('approve', $order);
    }



    //jika status == reject, dan reject reason !=NULL maka status akan berubah dan mencatat reason
    if($req->status === 'r') {
      if($req->reject_reason) {
      // put the approval to Log
      $order->approvalLogs()->attach([ $user->id => [ 'status' => $req->status , 'reason' => $req->reject_reason] ]);
      // put the user's approval status to replace old one
      $order->approvals()->sync([ $user->id => [ 'status' => $req->status ] ], false);
      }
    }
    else {
      // put the approval to Log
      $order->approvalLogs()->attach([ $user->id => [ 'status' => $req->status ] ]);


      // put the user's approval status to replace old one
      $order->approvals()->sync([ $user->id => [ 'status' => $req->status ] ], false);
    }



    // laravel belongsToMany sync bug, need to reload the order
    $order = Order::with( 'approvals', 'approvals.roles',
      'sells', 'sells.trader', 'sells.company',
      'buys', 'buys.trader', 'buys.company')->find($id);

    // Begin/Continue/End approval sequence
    if($req->status === 'a') $this->sequenceApproval($order);
    else $this->removeUpperAppr($order);


    $order->save();

    return $this->show($id, $req);
  }

  /**
   * Put new leads into the order
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function stage(Request $req, $id)
  {
    $order = Order::with('buys', 'sells', 'approvals', 'approvals.roles', 'trader')->find($id);

    // Check available volume
    $this->checkAvailable($order, $req);
    if ($order->available_volume === 'error') {
      return response()->json([ 'message' => 'Volume not avaliable' ], 400);
    }

    $lead_type = $req->lead_type;
    $this->authorize('update', $order);

    // Validate the Multiplicity of the leads inside this Orders
    if ($lead_type === 'buys'){
      if(count($order->sells) > 1 && !$req->notes && count($order->buys))
        return response()->json([ 'message' => 'Can\'t have Multiple Buy on Multiple Sells' ], 400);

      if($order->in_house)
        return response()->json([ 'message' => 'Can\'t add Buy when using House Products' ], 400);
    }

    else if ($lead_type === 'sells')
      if(count($order->buys) > 1 && !$req->notes && count($order->sells))
        return response()->json([ 'message' => 'Can\'t add more Sell on Multiple Buys' ], 400);

    if($req->lead_id) {
      $lead = Lead::with('Company','User','trader','used', 'Product')->find($req->lead_id);
      $message = $this->combineOrder($lead, $id);
    }

    // Update the data if pass all necessities
    $order->leads()->sync([ $req->lead_id => [
      'volume' => $req->volume,
      'base_currency_id' => $req->base_currency_id,
      'base_price' => $req->base_price,
      'deal_currency_id' => $req->deal_currency_id,
      'deal_price' => $req->deal_price,
      'exchange_rate' => $req->exchange_rate,
      'trading_term' => $req->trading_term,
      'payment_term' => $req->payment_term
    ]], false);
    Lead::find($req->lead_id)->reconcile();

    // when details are changed, reset all approval
    $this->resetApproval($order);

    // add negotiation log to the staged lead
    $order_detail_id = $order->leads()->find($req->lead_id)->pivot->id; // find the ID of the order details
    $negotiation  = new OrderNegotiation([
      'order_detail_id' => $order_detail_id,
      'notes' => $req->notes || 'Initial Deal',
      'volume' => $req->volume,
      'base_currency_id' => $req->base_currency_id,
      'base_price' => $req->base_price,
      'deal_currency_id' => $req->deal_currency_id,
      'deal_price' => $req->deal_price,
      'exchange_rate' => $req->exchange_rate,
      'trading_term' => $req->trading_term,
      'payment_term' => $req->payment_term,
      'user_id' => Auth::user()->id,
    ]);
    $negotiation->save();

    return $this->show($id, $req);
  }

  /**
   * Delete staged leads from the orders
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function unstage(Request $req, $id){
    $order = Order::with('approvals', 'approvals.roles', 'trader')->find($id);
    $this->authorize('update', $order);

    $order->leads()->detach($req->lead_id);
    Lead::find($req->lead_id)->reconcile();

    // when details are changed, reset all approval
    $this->resetApproval($order);

    return $this->show($id, $req);
  }
}
