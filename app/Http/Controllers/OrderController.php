<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Model\User;
use App\Model\BuyOrder;
use App\Model\SellOrder;
use App\Model\Order;
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
      $users = User::where('manager_id', Auth::User()->id)->get();
      $subordinates = [];
      foreach($users as $user){
        array_push($subordinates, $user->id);
      }
      $orders->whereIn('user_id', $subordinates);
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
    //$order->updated_at = date('Y-m-d H:i:s');
    
    if($order->status == 'x'){
      $buy_ids = $order->buys()->pluck('buy_order.id'); 
      BuyOrder::whereIn('id', $buy_ids)->update(['order_status' => 'p']);
      $sell_ids = $order->sells()->pluck('sell_order.id'); 
      SellOrder::whereIn('id', $sell_ids)->update(['order_status' => 'p']);
    }
    $order->save();

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
    $order = Order::with('trader', 'users', 'sells', 'sells.seller', 'buys', 'buys.buyer', 'buys.trader', 'approvals', 'buys.Factory', 'sells.Concession', 'sells.trader')->find($id);
    $details = [
      'volume' => $req->volume,
      'price' => $req->price,
      'trading_term' => $req->trading_term,
      'payment_term' => $req->payment_term
    ];

    if($req->buy) $order->buys()->attach([ $req->buy => $details ]);
    if($req->sell) $order->sells()->attach([ $req->sell => $details ]);

    return response()->json($order, 200);
  }
}
