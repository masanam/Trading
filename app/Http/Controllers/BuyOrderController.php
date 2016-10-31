<?php

namespace App\Http\Controllers;

use App\Model\BuyOrder;
use App\Model\Buyer;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;

// use App\Http\Traits\ActivityTrait as Activity;

class BuyOrderController extends Controller
{
    // use Activity;

    public function __construct() {
        $this->middleware('jwt.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $buy_order = BuyOrder::with('Buyer')->where('order_status', 'o')->get();
        return response()->json($buy_order, 200);
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

        $buy_order = new BuyOrder();

        $buy_order->user_id = Auth::User()->id;
        $buy_order->buyer_id = $request->buyer_id;

        $buy_order->order_date = date('Y-m-d',strtotime($request->order_date));
        $buy_order->order_deadline = date('Y-m-d',strtotime($request->order_deadline));
        $buy_order->ready_date = date('Y-m-d',strtotime($request->ready_date));
        $buy_order->expired_date = date('Y-m-d',strtotime($request->expired_date));

        $buy_order->address = $request->address;
        $buy_order->city = $request->city;
        $buy_order->country = $request->country;
        $buy_order->latitude = $request->latitude;
        $buy_order->longitude = $request->longitude;
        $buy_order->port_distance = $request->port_distance;
        $buy_order->port_id = $request->port_id;
        $buy_order->port_name = $request->port_name;
        $buy_order->port_status = $request->port_status;
        $buy_order->port_daily_rate = $request->port_daily_rate;
        $buy_order->port_draft_height = $request->port_draft_height;
        $buy_order->port_latitude = $request->port_latitude;
        $buy_order->port_longitude = $request->port_longitude;

        $buy_order->product_name = $request->product_name;
        $buy_order->product_id = $request->product_id;

        $buy_order->gcv_arb_min = $request->gcv_arb_min;
        $buy_order->gcv_arb_max = $request->gcv_arb_max;
        $buy_order->gcv_arb_reject = $request->gcv_arb_reject;
        $buy_order->gcv_arb_bonus = $request->gcv_arb_bonus;
        $buy_order->gcv_adb_min = $request->gcv_adb_min;
        $buy_order->gcv_adb_max = $request->gcv_adb_max;
        $buy_order->gcv_adb_reject = $request->gcv_adb_reject;
        $buy_order->gcv_adb_bonus = $request->gcv_adb_bonus;
        $buy_order->ncv_min = $request->ncv_min;
        $buy_order->ncv_max = $request->ncv_max;
        $buy_order->ncv_reject = $request->ncv_reject;
        $buy_order->ncv_bonus = $request->ncv_bonus;
        $buy_order->ash_min = $request->ash_min;
        $buy_order->ash_max = $request->ash_max;
        $buy_order->ash_reject = $request->ash_reject;
        $buy_order->ash_bonus = $request->ash_bonus;
        $buy_order->ts_min = $request->ts_min;
        $buy_order->ts_max = $request->ts_max;
        $buy_order->ts_reject = $request->ts_reject;
        $buy_order->ts_bonus = $request->ts_bonus;
        $buy_order->tm_min = $request->tm_min;
        $buy_order->tm_max = $request->tm_max;
        $buy_order->tm_reject = $request->tm_reject;
        $buy_order->tm_bonus = $request->tm_bonus;
        $buy_order->im_min = $request->im_min;
        $buy_order->im_max = $request->im_max;
        $buy_order->im_reject = $request->im_reject;
        $buy_order->im_bonus = $request->im_bonus;
        $buy_order->fc_min = $request->fc_min;
        $buy_order->fc_max = $request->fc_max;
        $buy_order->fc_reject = $request->fc_reject;
        $buy_order->fc_bonus = $request->fc_bonus;
        $buy_order->vm_min = $request->vm_min;
        $buy_order->vm_max = $request->vm_max;
        $buy_order->vm_reject = $request->vm_reject;
        $buy_order->vm_bonus = $request->vm_bonus;
        $buy_order->hgi_min = $request->hgi_min;
        $buy_order->hgi_max = $request->hgi_max;
        $buy_order->hgi_reject = $request->hgi_reject;
        $buy_order->hgi_bonus = $request->hgi_bonus;
        $buy_order->size_min = $request->size_min;
        $buy_order->size_max = $request->size_max;
        $buy_order->size_reject = $request->size_reject;
        $buy_order->size_bonus = $request->size_bonus;

        $buy_order->volume = $request->volume;
        $buy_order->max_price = $request->max_price;
        $buy_order->trading_term = $request->trading_term;
        $buy_order->payment_terms = $request->payment_terms;
        $buy_order->commercial_term = $request->commercial_term;
        $buy_order->penalty_desc = $request->penalty_desc;

        $buy_order->order_status = '1';
        $buy_order->progress_status = $request->progress_status;

        $buy_order->save();

        $buyer = Buyer::find($request->buyer_id);
        $buy_order->buyer = $buyer;

        $buy_order->order_date = $request->order_date;
        $buy_order->order_deadline = $request->order_deadline;
        $buy_order->ready_date = $request->ready_date;
        $buy_order->expired_date = $request->expired_date;

        // $activity = $this->storeActivity($buy_order->buyer_id, 'create', 'BuyOrder', $buy_order->id);

        return response()->json($buy_order, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $buy_order = BuyOrder::with('Buyer')->with('Port')->find($id);

        if($buy_order->order_status == 'o' || $buy_order->order_status == 1 || $buy_order->order_status == 2 || $buy_order->order_status == 3 || $buy_order->order_status == 4 || $buy_order->order_status == 'l') {
            return response()->json($buy_order, 200);
        }else {
            return response()->json(['message' => 'deactivated record'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $buy_order = BuyOrder::find($id);
     
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$buy_order) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $buy_order->user_id = Auth::User()->id;
        $buy_order->buyer_id = $request->buyer_id;

        $buy_order->order_date = date('Y-m-d',strtotime($request->order_date));
        $buy_order->order_deadline = date('Y-m-d',strtotime($request->order_deadline));
        $buy_order->ready_date = date('Y-m-d',strtotime($request->ready_date));
        $buy_order->expired_date = date('Y-m-d',strtotime($request->expired_date));

        $buy_order->address = $request->address;
        $buy_order->city = $request->city;
        $buy_order->country = $request->country;
        $buy_order->latitude = $request->latitude;
        $buy_order->longitude = $request->longitude;
        $buy_order->port_distance = $request->port_distance;
        $buy_order->port_id = $request->port_id;
        $buy_order->port_name = $request->port_name;
        $buy_order->port_status = $request->port_status;
        $buy_order->port_daily_rate = $request->port_daily_rate;
        $buy_order->port_draft_height = $request->port_draft_height;
        $buy_order->port_latitude = $request->port_latitude;
        $buy_order->port_longitude = $request->port_longitude;

        $buy_order->product_name = $request->product_name;
        $buy_order->product_id = $request->product_id;

        $buy_order->gcv_arb_min = $request->gcv_arb_min;
        $buy_order->gcv_arb_max = $request->gcv_arb_max;
        $buy_order->gcv_arb_reject = $request->gcv_arb_reject;
        $buy_order->gcv_arb_bonus = $request->gcv_arb_bonus;
        $buy_order->gcv_adb_min = $request->gcv_adb_min;
        $buy_order->gcv_adb_max = $request->gcv_adb_max;
        $buy_order->gcv_adb_reject = $request->gcv_adb_reject;
        $buy_order->gcv_adb_bonus = $request->gcv_adb_bonus;
        $buy_order->ncv_min = $request->ncv_min;
        $buy_order->ncv_max = $request->ncv_max;
        $buy_order->ncv_reject = $request->ncv_reject;
        $buy_order->ncv_bonus = $request->ncv_bonus;
        $buy_order->ash_min = $request->ash_min;
        $buy_order->ash_max = $request->ash_max;
        $buy_order->ash_reject = $request->ash_reject;
        $buy_order->ash_bonus = $request->ash_bonus;
        $buy_order->ts_min = $request->ts_min;
        $buy_order->ts_max = $request->ts_max;
        $buy_order->ts_reject = $request->ts_reject;
        $buy_order->ts_bonus = $request->ts_bonus;
        $buy_order->tm_min = $request->tm_min;
        $buy_order->tm_max = $request->tm_max;
        $buy_order->tm_reject = $request->tm_reject;
        $buy_order->tm_bonus = $request->tm_bonus;
        $buy_order->im_min = $request->im_min;
        $buy_order->im_max = $request->im_max;
        $buy_order->im_reject = $request->im_reject;
        $buy_order->im_bonus = $request->im_bonus;
        $buy_order->fc_min = $request->fc_min;
        $buy_order->fc_max = $request->fc_max;
        $buy_order->fc_reject = $request->fc_reject;
        $buy_order->fc_bonus = $request->fc_bonus;
        $buy_order->vm_min = $request->vm_min;
        $buy_order->vm_max = $request->vm_max;
        $buy_order->vm_reject = $request->vm_reject;
        $buy_order->vm_bonus = $request->vm_bonus;
        $buy_order->hgi_min = $request->hgi_min;
        $buy_order->hgi_max = $request->hgi_max;
        $buy_order->hgi_reject = $request->hgi_reject;
        $buy_order->hgi_bonus = $request->hgi_bonus;
        $buy_order->size_min = $request->size_min;
        $buy_order->size_max = $request->size_max;
        $buy_order->size_reject = $request->size_reject;
        $buy_order->size_bonus = $request->size_bonus;

        $buy_order->volume = $request->volume;
        $buy_order->max_price = $request->max_price;
        $buy_order->trading_term = $request->trading_term;
        $buy_order->payment_terms = $request->payment_terms;
        $buy_order->commercial_term = $request->commercial_term;
        $buy_order->penalty_desc = $request->penalty_desc;

        $buy_order->order_status = $request->order_status;
        $buy_order->progress_status = $request->progress_status;

        $buy_order->save();

        $buy_order->order_date = $request->order_date;
        $buy_order->order_deadline = $request->order_deadline;
        $buy_order->ready_date = $request->ready_date;
        $buy_order->expired_date = $request->expired_date;

        return response()->json($buy_order, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $buy_order = BuyOrder::find($id);

        if (!$buy_order) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $buy_order->order_status = 'x';
        $buy_order->save();

        return response()->json($buy_order, 200);
    }

    // public function indexDetailed () {
    //     $buy_order = BuyOrder::with()
    // }

    public function status($order_status, $progress_status = false)
    {
        if (!$progress_status) {
            $buy_order = BuyOrder::with('Buyer')->where('order_status', $order_status)->get();
        } else {
            $buy_order = BuyOrder::with('Buyer')->where('order_status', $order_status)->where('progress_status', 'LIKE', '%'.$progress_status.'%')->get();
        }

        return response()->json($buy_order, 200);
    }

    public function changeOrderStatus($id, $order_status)
    {
        $buy_order = BuyOrder::find($id);

        if (!$buy_order) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        if ($order_status) {
          $buy_order->order_status = $order_status;
          $buy_order->save();
        }

        return response()->json($buy_order, 200);
    }

    public function myBuyOrders($id)
    {
        $buy_order = BuyOrder::with('Buyer')->where('order_status', 'o')->get();
        return response()->json($buy_order, 200);
    }
}
