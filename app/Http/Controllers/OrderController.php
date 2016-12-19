<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Model\User;
use App\Model\Lead;
use App\Model\Order;
use App\Model\IndexPrice;
use App\Model\Index;
use App\Model\OrderNegotiation;

use Tymon\JWTAuth\Facades\JWTAuth;
use Auth;

class OrderController extends Controller
{
  public function __construct(Order $order)
  {
    $this->middleware('jwt.auth', [ 'except' => 'approval' ]);
    $this->order = $order;
  }
  
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
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $req)
  {
    if($req->funnel == true) return $this->funnel();

    //DB::enableQueryLog();
    $orders = Order::with('trader', 'approvals');

    if($req->status != '') $orders = $orders->where('status', $req->status);

    if($req->possession == 'subordinates'){
      $subs = Auth::user()->subordinates();
      $users = $subs->pluck('id')->all(); 
      $orders = $orders->whereIn('user_id', $users);
    }
    else if($req->possession == 'associated'){
      $orders->whereHas('users', function($query){
        $query->where('user_id', Auth::user()->id);
      });
    }else{
      $orders->where('user_id', Auth::user()->id);
    }

    //var_dump(DB::getQueryLog());
    $orders = $orders->get();

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

    return response()->json($req, 200);
    if(!$req) {
      return response()->json([
        'message' => 'Bad Request'
      ], 400);
    }

    $order = new Order();
    $order->user_id = Auth::User()->id;
    $order->status = 'd';
    $order->save();
    
    // Check the availability of associated leads
    if(count($req->buys) > 0){
      foreach($req->buys as $buy){
        $order->buys()->attach([ $buy['id'] => $buy['pivot'] ]);
        Lead::find($buy['id'])->reconcile();

        OrderNegotiation::create([
          'order_detail_id' => $buy['id'],
          'notes' => 'Initial Deal',
          'volume' => $buy['pivot']['volume'],
          'price' => $buy['pivot']['price'],
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

        // $order_detail = $order->orders->find($sell['id']);
        OrderNegotiation::create([
          'order_detail_id' => $sell['id'],
          'notes' => 'Initial Deal',
          'volume' => $sell['pivot']['volume'],
          'price' => $sell['pivot']['price'],
          'trading_term' => $sell['pivot']['trading_term'],
          'payment_term' => $sell['pivot']['payment_term'],
          'user_id' => Auth::user()->id,
        ]);
      }
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
    $order = Order::with('trader', 'users', 'sells', 'buys', 'buys.trader',
      'approvals', 'sells.trader', 'sells.company', 'buys.company', 'buys.concession', 'sells.factory')->find($id);

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
        $index = $this->indexPrice();

        $json = [
          'status' => 200,
          'error' => 'ok',
          'order' => $order,
          'index' => $index
        ];
      } else $json = $order;
    } else $json = $order;

    return response()->json($json, 200);;
  }

  /**
   * edit the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $req, $id)
  {
    $order = Order::find($id);

    if(!$req) return response()->json([ 'message' => 'Bad Request' ], 400);
    if (!$order) return response()->json([ 'message' => 'Not found' ] ,404);
    if ($order->user_id != Auth::user()->id) return response()->json([ 'message' => 'You are not authorized to edit this order!' ] ,403);

    $this->authorize('update', $order);

    if(count($order->buys) > 0){
      foreach($order->buys as $buy){
        BuyOrder::find($buy['id'])->reconcile();
      }
    }
    if(count($req->sells) > 0) {
      foreach($req->sells as $sell){
        SellOrder::find($sell['id'])->reconcile();
      }
    }

    $order->status = $req->status;
    $order->save();
    //$order->updated_at = date('Y-m-d H:i:s');

    if($order->status == 'x'){
      $buy_ids = $order->buys()->pluck('buy_order.id');
      BuyOrder::whereIn('id', $buy_ids)->update(['order_status' => 'p']);
      $sell_ids = $order->sells()->pluck('sell_order.id');
      SellOrder::whereIn('id', $sell_ids)->update(['order_status' => 'p']);
    }
    else if($order->status == 'p'){
      $order = Order::with(['approvals' => function($q){
        $q->where('user_id', Auth::user()->manager_id);
      }, 'users' => function($q){
        $q->where('user_id', Auth::user()->manager_id);
      }])->find($id);


      if(count($req->buys) > 0){
        foreach($req->buys as $buy){
          $order->buys()->attach([ $buy['id'] => $buy['pivot'] ]);
          Lead::find($buy['id'])->reconcile();

          OrderNegotiation::create([
            'order_detail_id' => $buy['id'],
            'notes' => 'Initial Deal',
            'volume' => $buy['pivot']['volume'],
            'price' => $buy['pivot']['price'],
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

          // $order_detail = $order->orders->find($sell['id']);
          OrderNegotiation::create([
            'order_detail_id' => $sell['id'],
            'notes' => 'Initial Deal',
            'volume' => $sell['pivot']['volume'],
            'price' => $sell['pivot']['price'],
            'trading_term' => $sell['pivot']['trading_term'],
            'payment_term' => $sell['pivot']['payment_term'],
            'user_id' => Auth::user()->id,
          ]);
        }
      }

      // add manager to approve this order
      if($user->manager_id){
        $order->requestApproval(User::find($user->manager_id));
      } else {
        $order->status = 'a'; $order->save();
      }
    }

    return $this->show($id);
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
    // since approval does not use jwt middleware,
    // we need to try whether they are using approval token
    // or using the JWT token.
    $order = Order::with( 'approvals',
      'sells', 'sells.trader', 'sells.company', 
      'buys', 'buys.trader', 'buys.company')->find($id);

    if($req->approval_token) $user = $order->getApproverByToken($req->approval_token); // if using token, get the specified approving user
    else {
      $user = JWTAuth::parseToken()->authenticate(); // or simply load the user if using Auth only.
      $this->authorize('approve', $order);
    }

    // put the user's approval status to replace old one
    $order->approvals()->sync([ $user->id => [ 'status' => $req->status ] ], false);

    // if this user has manager, add approval on top of it
    if($user->manager_id){
      $order->requestApproval(User::find($user->manager_id));
    }

    return $this->show($id);
  }

  /**
   * Put new leads into the order
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function stage(Request $req, $id)
  {
    $order = Order::with('buys', 'sells')->find($id);
    $details = [
      'volume' => $req->volume,
      'price' => $req->price,
      'trading_term' => $req->trading_term,
      'payment_term' => $req->payment_term
    ];
    if(!$req->notes) $notes = 'Initial Deal';
    else $notes = $req->notes;

    $lead_type = $req->lead_type;

    $this->authorize('update', $order);
    if ($lead_type === 'buys') 
      if(count($order->sells) > 1)
        return response()->json([ 'message' => 'Can\'t add more Buy on Multiple Sells' ], 400);
    else if ($lead_type === 'sells') 
      if(count($order->buys) > 1)
        return response()->json([ 'message' => 'Can\'t add more Sell on Multiple Buys' ], 400);

    if (!$req->negotiation){
      $order->$lead_type()->sync([ $req->lead_id => $details ], false);
      Lead::find($req->lead_id)->reconcile();
    }

    $order_detail_id = $order->$lead_type()->find($req->lead_id)->pivot->id;

    // if notes is here, it's a negotiation
    // Add new log of the nagotiation
    $negotiation  = new OrderNegotiation([
      'order_detail_id' => $order_detail_id,
      'notes' => $notes,
      'volume' => $req->volume,
      'price' => $req->price,
      'trading_term' => $req->trading_term,
      'payment_term' => $req->payment_term,
      'user_id' => Auth::user()->id,
    ]);
    $negotiation->save();
    return $this->show($id);
  }

  public function unstage(Request $req, $id){
    $order = Order::find($id);
    $this->authorize('view', $order);
    if(isset($req->buy_id)) $order->buys()->detach($req->buy_id);
    if(isset($req->sell_id)) $order->sells()->detach($req->sell_id);

    return $this->show($id);
  }

}
