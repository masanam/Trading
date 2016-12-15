<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Model\User;
use App\Model\BuyOrder;
use App\Model\SellOrder;
use App\Model\OrderUser;
use App\Model\Lead;
use App\Model\Order;
use App\Model\IndexPrice;
use App\Model\Index;
use App\Model\OrderApproval;
use App\Model\OrderNegotiation;
use App\Mail\ApprovalRequest;

use Auth;

class OrderController extends Controller
{
  public function __construct(Order $order)
  {
    $this->middleware('jwt.auth', [ 'except' => ['approveNow', 'rejectNow'] ]);
    $this->order = $order;
  }

  // private function add_user_to_order($order = NULL, $user_id = '', $order_id='', $role=''){
  //   if($order->users->count() == 0){
  //     $order_user = new OrderUser();
  //     $order_user->order_id = $order_id;
  //     $order_user->user_id = $user_id;
  //     $order_user->role = $role;
  //     $order_user->save();
  //   }
  // }
  
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

  // private function send_approval_mail($order, $user_id){
  //   $user = User::findOrFail($user_id);
  //   Mail::to($user->email)->send(new ApprovalRequest($order));
  // }

  // private function add_approval_to_order($order = NULL, $user_id = '', $order_id='', $status=''){
  //   //var_dump($order->approvals->count());
  //   if($order->approvals->count() > 0){
  //     $order_approval = OrderApproval::where('user_id', $user_id)->where('order_id', $order_id)->first();
  //     $order_approval->status = $status;
  //     $order_approval->save();
      
  //     $this->send_approval_mail($order, $user_id);
  //   }else{
  //     $order_approval = new OrderApproval();
  //     $order_approval->order_id = $order_id;
  //     $order_approval->user_id = $user_id;
  //     $order_approval->status = $status;
  //     $order_approval->save();

  //     $this->send_approval_mail($order, $user_id);
  //   }
  // }

  // public function testMail($id){
  //   $order = Order::findOrFail($id);
  //   $this->send_approval_mail($order, 4);

  //   return response()->json([ 'message' => 'Sent!' ], 200);
  // }

  // public function approveNow($id){
  //   $order = Order::findOrFail($id);
  //   $order->approvals()->sync([1 => [ 'status' => 'a' ]], false);

  //   return 'You Have Succesfuly Approved this Order';
  // }

  // public function rejectNow($id){
  //   $order = Order::findOrFail($id);
  //   $order->approvals()->sync([1 => [ 'status' => 'r' ]], false);

  //   return 'You Have Succesfuly Rejected this Order';
  // }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $req)
  {
    DB::enableQueryLog();
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
   *
   * @param  \Illuminate\Http\Request  $req
   * @return \Illuminate\Http\Response
   */
  public function store(Request $req)
  {
    if(!$req) {
      return response()->json([
        'message' => 'Bad Request'
      ], 400);
    }
    // return $req;
    $order = new Order();
    $order->user_id = Auth::User()->id;
    $order->status = 'd';
    $order->save();

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
          'insurance_cost' => $buy['additional']['insurance_cost'],
          'interest_cost' => $buy['additional']['interest_cost'],
          'surveyor_cost' => $buy['additional']['surveyor_cost'],
          'others_cost' => $buy['additional']['others_cost'],
          'pit_to_port' => $buy['additional']['pit_to_port'],
          'transhipment' => $buy['additional']['transhipment'],
          'freight_cost' => $buy['additional']['freight_cost'],
          'port_to_factory' => $buy['additional']['port_to_factory'],
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
          'insurance_cost' => $sell['additional']['insurance_cost'],
          'interest_cost' => $sell['additional']['interest_cost'],
          'surveyor_cost' => $sell['additional']['surveyor_cost'],
          'others_cost' => $sell['additional']['others_cost'],
          'pit_to_port' => $sell['additional']['pit_to_port'],
          'transhipment' => $sell['additional']['transhipment'],
          'freight_cost' => $sell['additional']['freight_cost'],
          'port_to_factory' => $sell['additional']['port_to_factory'],
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
  public function show($id, Request $req)
  { 
    $order = Order::with('trader', 'users', 'sells', 'buys', 'buys.trader',
      'approvals', 'sells.trader', 'sells.company', 'buys.company', 'buys.concession', 'sells.factory')->find($id);

    // $this->authorize('view', $order);

    // lazyloading semua negotiation log
    $order->getNegotiations();

    // get the earliest laycan and latest one
    $order->earliestLaycan();
    $order->latestLaycan();

    // find all averages of the order details.
    $order->averageSell(); 
    $order->averageBuy();
    
    // IF envelope is requested, get all necessary components
    if($req->envelope == "true"){
      $params = [
        'date' => date('Y-m-d', strtotime($order->created_at)),
        'latest' => 7
      ];
      
      // get index to fill things up
      $index = $this->indexPrice(10, $params);

      $json = [
        'status' => 200,
        'error' => 'ok',
        'order' => $order,
        'index' => $index
      ];
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

    if(!$req) {
      return response()->json([
        'message' => 'Bad Request'
      ], 400);
    }
    if (!$order) {
      return response()->json([
        'message' => 'Not found'
      ] ,404);
    }
    if ($order->user_id != Auth::user()->id) {
      return response()->json([
        'message' => 'You are not authorized to edit this order!'
      ] ,403);
    }
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

      $this->add_user_to_order($order, Auth::user()->manager_id, $id, 'approver');
      $this->add_approval_to_order($order, Auth::user()->manager_id, $id, 'p');
    }

    return $this->show($id);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function approve($id, Request $req)
  {
    $order = Order::with(['approvals' => function($q){
        $q->where('user_id', Auth::user()->id);
      }, 'users' => function($q){
        $q->where('user_id', Auth::user()->id);
      }])->find($id);

    $this->add_approval_to_order($order, Auth::user()->id, $id, $req->status);

    //print_r($order);

    if($req->status == 'a'){
      if(!Auth::user()->manager_id){
        $order->status = 'a';
        $order->save();
      }else{
        $order = Order::with(['approvals' => function($q){
          $q->where('user_id', Auth::user()->manager_id);
        }, 'users' => function($q){
          $q->where('user_id', Auth::user()->manager_id);
        }])->find($id);

        $this->add_user_to_order($order, Auth::user()->manager_id, $id, 'approver');
        $this->add_approval_to_order($order, Auth::user()->manager_id, $id, 'p');
        $order->status = 'p';
        $order->save();
      }
    }

    return $this->show($id);
  }

  public function funnel()
  {
    $get=Order::orderBy('status')->select('status')->where('status','!=','c')->where('status','!=','x')->where('status','!=','d')->get();
    $getLeadsell=SellOrder::orderBy('order_status')->select('order_status')->where('order_status','=','v')->orWhere('order_status','=','l')->count();
    $getLeadbuy=BuyOrder::orderBy('order_status')->select('order_status')->where('order_status','=','v')->orWhere('order_status','=','l')->count();
    $pending=0;
    $Finalized=0;
    $approved=0;
    $sum=['lead-sell'=>0,'lead-buy'=>0,'pending'=>0,'approved'=>0,'finalized'=>0];
    foreach ($get as $count) {
    if ($count->status=='p') {
        $pending=$pending+1;
      }
      elseif ($count->status=='e') {
        $approved=$approved+1;
      }
      elseif ($count->status=='e') {
        $Finalized=$Finalized+1;
      }
    }
    $sum=['lead-sell'=>$getLeadsell,'lead-buy'=>$getLeadbuy,'pending'=>$pending,'approved'=>$approved,'finalized'=>$Finalized];
    return response()->json($sum,200);
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

    $this->authorize('update', $order);
    if($req->buy){
      if(count($order->sells) > 1)
        return response()->json([ 'message' => 'Can\'t add more Buy on Multiple Sells' ], 400);

      $order->buys()->sync([ $req->buy => $details ], false);

      Lead::find($req->buy)->reconcile();
      $lead_staged = $order->buys()->with('Company','User','trader')->find($req->buy);

      $order_detail_id = $order->buys()->find($req->buy)->pivot->id;
    }
    if($req->sell){
      if(count($order->buys) > 1)
        return response()->json([ 'message' => 'Can\'t add more Sell on Multiple Buys' ], 400);

      $order->sells()->sync([ $req->sell => $details ], false);

      Lead::find($req->sell)->reconcile();
      $lead_staged = $order->sells()->with('Company','User','trader')->find($req->sell);

      $order_detail_id = $order->sells()->find($req->sell)->pivot->id;
    }

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
    return response()->json($lead_staged,200);
  }

  public function unstage(Request $req, $id){
    $order = Order::find($id);
    $this->authorize('view', $order);
    if(isset($req->buy_id)) $order->buys()->detach($req->buy_id);
    if(isset($req->sell_id)) $order->sells()->detach($req->sell_id);

    return $this->show($id);
  }

  public function stageOwn($id){
    $order = Order::with('sells', 'buys')->find($id);
    $this->authorize('update', $order);

    if(count($order->sells) && count($order->buys)>1)
      return response()->json([ 'message'=> 'Multiple Buy & Sell can\'t add more'], 400);

    //cari selisih volume
    $sell_volume = $order->sells->sum('pivot.volume');
    $buy_volume = $order->buys->sum('pivot.volume');

    $volume = $buy_volume - $sell_volume;

    if($volume <= 0)
      return response()->json([ 'message'=> 'Sourcing is more than Market'], 400);

    $sell = SellOrder::create([
      'user_id' => Auth::user()->id,
      'seller_id' => 1, //ganti sesuai siapa penjual default
      'city' => 'JKT',
      'country' => 'ID',
      'commercial_term' => '',

      'address' => 'Jl. Kapten Darmo Sugondo No.56, Sidorukun, Kec. Gresik, Kabupaten Gresik, Jawa Timur',
      'latitude' => '-7.1844498' ,
      'longitude' => '112.6528737' ,

      'order_date' => date('Y-m-d'),
      'order_deadline' => date('Y-m-d'),
      'penalty_desc' => 'penalty',
      'ready_date'=> date('Y-m-d'),
      'expired_date'=> date('Y-m-d'),

      'volume' => $volume,
      'order_status' => 'v'
    ]);

    $sell->leads()->attach([ $id => [
      'volume' => $volume,
      'price' => 0,
      'trading_term' => 'FOB MV',
      'payment_term' => 'NET30',
    ]]);

    return $this->show($id);
  }

}
