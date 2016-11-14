<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Model\User;
use App\Model\BuyOrder;
use App\Model\SellOrder;
use App\Model\OrderUser;
use App\Model\Order;
use App\Model\OrderApproval;
use App\Model\OrderNegotiation;
use Auth;

class OrderController extends Controller
{
  public function __construct(Order $order)
  {
    $this->middleware('jwt.auth');
    $this->order = $order;
  }

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
      $subordinates = $this->getSub();
      foreach ($subordinates as $sub ) {
          $lower[] = $sub->id;
      }
      $orders = $orders->whereIn('user_id', $lower);
    }
    else if($req->possession == 'associated'){
      $orders->whereHas('users', function($query){
        $query->where('user_id', Auth::User()->id);
      });
    }else{
      $orders->where('user_id', Auth::User()->id);
    }
    
    //var_dump(DB::getQueryLog());
    $orders = $orders->get();
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
    $order = new Order($req->except(['buys', 'sells']));
    $order->user_id = Auth::User()->id;
    $order->status = 'd';
    $order->save();

    if(count($req->buys) > 0)
      foreach($req->buys as $buy){
        $order->buys()->attach([
          $buy['id'] => $buy['pivot'] 
        ]);
        BuyOrder::find($buy['id'])->reconcile();

        $order_detail = $order->buys->find($buy['id']);
        OrderNegotiation::create([
          'order_detail_id' => $order_detail->id,
          'notes' => 'Initial Deal',
          'volume' => $order_detail->pivot->volume,
          'price' => $order_detail->pivot->price,
          'user_id' => Auth::user()->id,
        ]);
      }
    if(count($req->sells) > 0)
      foreach($req->sells as $sell){
        $order->sells()->attach([ $sell['id'] => $sell['pivot'] ]);
        SellOrder::find($sell['id'])->reconcile();

        $order_detail = $order->sells->find($sell['id'])->pivot->id;
        OrderNegotiation::create([
          'order_detail_id' => $order_detail->id,
          'notes' => 'Initial Deal',
          'volume' => $order_detail->pivot->volume,
          'price' => $order_detail->pivot->price,
          'user_id' => Auth::user()->id,
        ]);
      }

    return response()->json($order, 200);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $order = Order::with('trader', 'users', 'sells', 'sells.seller', 'buys', 'buys.buyer', 'buys.trader', 'approvals', 'buys.Factory', 'sells.Concession', 'sells.trader')->find($id);
    $this->authorize('view', $order);

    // lazyloading semua negotiation log
    foreach($order->sells as &$sell){
      if($sell->user_id !== Auth::user()->id) $sell->seller = $sell->location = $sell->port_name = $sell->address = '-hidden value-';
      $sell->pivot->negotiations = OrderNegotiation::where('order_detail_id', '=', $sell->pivot->id)->get();
    }
    foreach($order->buys as &$buy){
      if($buy->user_id !== Auth::user()->id) $buy->buyer = $buy->location = $buy->port_name = $buy->address = '-hidden value-';
      $buy->pivot->negotiations = OrderNegotiation::where('order_detail_id', '=', $buy->pivot->id)->get();
    }

    return response()->json($order, 200);
  }
  
  private function add_user_to_order($order = NULL, $user_id = '', $order_id='', $role=''){
    if($order->users->count() == 0){
      $order_user = new OrderUser();
      $order_user->order_id = $order_id;
      $order_user->user_id = $user_id;
      $order_user->role = $role;
      $order_user->save();
    }
  }
  
  private function add_approval_to_order($order = NULL, $user_id = '', $order_id='', $status=''){
    //var_dump($order->approvals->count());
    if($order->approvals->count() > 0){
      $order_approval = OrderApproval::where('user_id', $user_id)->where('order_id', $order_id)->first();
      $order_approval->status = $status;
      $order_approval->save();
    }else{
      $order_approval = new OrderApproval();
      $order_approval->order_id = $order_id;
      $order_approval->user_id = $user_id;
      $order_approval->status = $status;
      $order_approval->save();
    }
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

    $order->finalize_reason = $req->finalize_reason;
    $order->cancel_reason = $req->cancel_reason;
    $order->request_reason = $req->request_reason;
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

    return response()->json($order, 200);
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
          $q->where('user_id', Auth::manager()->id);
        }, 'users' => function($q){
          $q->where('user_id', Auth::manager()->id);
        }])->find($id);
      
        $this->add_user_to_order($order, Auth::user()->manager_id, $id, 'approver');
        $this->add_approval_to_order($order, Auth::user()->manager_id, $id, 'p');
        $order->status = 'p';
        $order->save();
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

  public function stage(Request $req, $id)
  {
    $order = Order::with('sells', 'buys')->find($id);
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
        return response()->json([ 'message' => 'Can\'t add more Sell on Multiple Buys' ], 400);
      
      $order->buys()->sync([ $req->buy => $details ], false);

      $buy = BuyOrder::find($req->buy)->reconcile();

      $order_detail_id = $order->buys->find($req->buy)->pivot->id;
    }
    if($req->sell){
      if(count($order->buys) > 1)
        return response()->json([ 'message' => 'Can\'t add more Buy on Multiple Sells' ], 400);
      
      $order->sells()->sync([ $req->sell => $details ], false);

      $sell = SellOrder::find($req->sell)->reconcile();

      $order_detail_id = $order->sells->find($req->sell)->pivot->id;
    }

    // if notes is here, it's a negotiation
    // Add new log of the nagotiation
    $negotiation  = new OrderNegotiation([
      'order_detail_id' => $order_detail_id,
      'notes' => $notes,
      'volume' => $req->volume,
      'price' => $req->price,
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

  public function stageOwn($id){
    $order = Order::with('sells', 'buys')->find($id);
    $this->authorize('update', $order);

    if(count($order->sells) && count($order->buys)>1)
      return response()->json([ 'message'=> 'Multiple Buy & Sell can\'t add more'], 400);

    //cari selisih volume
    $sell_volume = $order->sells->sum('pivot.volume');
    $buy_volume = $order->buys->sum('pivot.volume');

    $volume = $buy_volume - $sell_volume;

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

    $sell->orders()->attach([ $id => [
      'volume' => $volume, 
      'price' => 0,
      'trading_term' => 'FOB MV',
      'payment_term' => 'NET30',
    ]]);

    return $this->show($id);
  }

  public function getSub(){
    $user = Auth::User();
    return $user->getAllSubordinates();
  }
}
