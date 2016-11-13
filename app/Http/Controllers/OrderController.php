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
  public function index(Request $request)
  {
    DB::enableQueryLog();
    $orders = Order::with('trader', 'approvals');

    if($request->status != '') $orders = $orders->where('status', $request->status);
    
    if($request->possession == 'subordinates'){
      $subordinates = $this->getSub();
      foreach ($subordinates as $sub ) {
          $lower[] = $sub->id;
      }
      $orders = $orders->whereIn('user_id', $lower);
    }
    else if($request->possession == 'associated'){
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
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if(!$request) {
      return response()->json([
        'message' => 'Bad Request'
      ], 400);
    }
    $order = new Order($request);
    $order->user_id = Auth::User()->id;
    $order->status = 'd';
    $order->save();

    foreach($request->buys as $buy){
      $order->buys()->attach([ $buy->id => $buy->pivot ]);
      BuyOrder::find($buy->id)->reconcile();
    }
    foreach($request->sells as $sell){
      $order->sells()->attach([ $sell->id => $sell->pivot ]);
      SellOrder::find($sell->id)->reconcile();
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
    if($order->approvals->count() > 0){
      $order_approval = OrderApproval::where('user_id', $user_id)->where('order_id', $order_id)->first();
      $order_approval->status = 'p';
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
  public function update(Request $request, $id)
  {
    $order = Order::find($id);

    if(!$request) {
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

    $order->finalize_reason = $request->finalize_reason;
    $order->cancel_reason = $request->cancel_reason;
    $order->request_reason = $request->request_reason;
    $order->status = $request->status;
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
  public function approve($id, Request $request)
  {
    $order = Order::with(['approvals' => function($q){
      $q->where('user_id', Auth::user()->id);
    }])->find($id);
    
    if($order->approvals->count() > 0){
      $order_approval = OrderApproval::where('user_id', Auth::user()->id)->where('order_id', $id)->first();
      $order_approval->status = $request->status;
      $order_approval->save();
    }else{
      $this->add_approval_to_order($order, Auth::user()->manager_id, $id, $request->status);
    }
    
    //print_r($order);
    
    if($request->status == 'a'){
      if(!Auth::user()->manager_id){
        $order->status = 'a';
        $order->save();
      }else{
        $this->add_user_to_order($order, Auth::user()->manager_id, $id, 'approver');
        $this->add_approval_to_order($order, Auth::user()->manager_id, $id, 'p');
        $order->status = 'p';
        $order->save();
      }
    }
    
    $order = Order::with('trader', 'users', 'sells', 'sells.seller', 'buys', 'buys.buyer', 'buys.trader', 'approvals', 'buys.Factory', 'sells.Concession', 'sells.trader')->find($id);

    return response()->json($order, 200);
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
    if($req->buy){
      OrderNegotiation::create([
        'order_detail_id' => $order_detail_id,
        'notes' => $req->notes,
        'volume' => $req->volume,
        'price' => $req->price,
        'trading_term' => $req->trading_term,
        'payment_term' => $req->payment_term
      ]);
    }

    $order = Order::with('trader', 'users', 'sells', 'sells.seller', 'buys', 'buys.buyer', 'buys.trader', 'approvals', 'buys.Factory', 'sells.Concession', 'sells.trader')->find($id);

    return $this->show($id);
  }

  public function getSub(){
    $user = Auth::User();
    return $user->getAllSubordinates();
  }
}
