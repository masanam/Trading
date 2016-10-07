<?php

namespace App\Http\Controllers;

use App\Model\SellOrder;

use Illuminate\Http\Request;

use App\Http\Requests;

class SellOrderController extends Controller
{
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
        $sell_order = SellOrder::with('seller')->where('order_status', 'a')->get();

        return response()->json($sell_order, 200);
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

        $sell_order = new SellOrder();

        $sell_order->user_id = $request->user_id;
        $sell_order->seller_id = $request->seller_id;

        $sell_order->order_date = $request->order_date;
        $sell_order->penalty_desc = $request->penalty_desc;
        $sell_order->deadline = $request->deadline;

        $sell_order->address = $request->address;
        $sell_order->latitude = $request->latitude;
        $sell_order->longitude = $request->longitude;

        $sell_order->gcv_arb_min = $request->gcv_arb_min;
        $sell_order->gcv_arb_max = $request->gcv_arb_max;
        $sell_order->gcv_arb_reject = $request->gcv_arb_reject;
        $sell_order->gcv_arb_bonus = $request->gcv_arb_bonus;
        $sell_order->gcv_adb_min = $request->gcv_adb_min;
        $sell_order->gcv_adb_max = $request->gcv_adb_max;
        $sell_order->gcv_adb_reject = $request->gcv_adb_reject;
        $sell_order->gcv_adb_bonus = $request->gcv_adb_bonus;
        $sell_order->ncv_min = $request->ncv_min;
        $sell_order->ncv_max = $request->ncv_max;
        $sell_order->ncv_reject = $request->ncv_reject;
        $sell_order->ncv_bonus = $request->ncv_bonus;
        $sell_order->ash_min = $request->ash_min;
        $sell_order->ash_max = $request->ash_max;
        $sell_order->ash_reject = $request->ash_reject;
        $sell_order->ash_bonus = $request->ash_bonus;
        $sell_order->ts_min = $request->ts_min;
        $sell_order->ts_max = $request->ts_max;
        $sell_order->ts_reject = $request->ts_reject;
        $sell_order->ts_bonus = $request->ts_bonus;
        $sell_order->tm_min = $request->tm_min;
        $sell_order->tm_max = $request->tm_max;
        $sell_order->tm_reject = $request->tm_reject;
        $sell_order->tm_bonus = $request->tm_bonus;
        $sell_order->im_min = $request->im_min;
        $sell_order->im_max = $request->im_max;
        $sell_order->im_reject = $request->im_reject;
        $sell_order->im_bonus = $request->im_bonus;
        $sell_order->fc_min = $request->fc_min;
        $sell_order->fc_max = $request->fc_max;
        $sell_order->fc_reject = $request->fc_reject;
        $sell_order->fc_bonus = $request->fc_bonus;
        $sell_order->vm_min = $request->vm_min;
        $sell_order->vm_max = $request->vm_max;
        $sell_order->vm_reject = $request->vm_reject;
        $sell_order->vm_bonus = $request->vm_bonus;
        $sell_order->hgi_min = $request->hgi_min;
        $sell_order->hgi_max = $request->hgi_max;
        $sell_order->hgi_reject = $request->hgi_reject;
        $sell_order->hgi_bonus = $request->hgi_bonus;
        $sell_order->size_min = $request->size_min;
        $sell_order->size_max = $request->size_max;
        $sell_order->size_reject = $request->size_reject;
        $sell_order->size_bonus = $request->size_bonus;

        $sell_order->volume = $request->volume;
        $sell_order->max_price = $request->max_price;
        
        $sell_order->status = 'a';
        
        $sell_order->save();

        return response()->json($sell_order, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($sell_order)
    {
        $sell_order = SellOrder::with('seller')->find($sell_order);
        
        if($sell_order->order_status == 'a') {
            return response()->json($sell_order, 200);
        } else {
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
    public function update(Request $request, SellOrder $sell_order)
    {
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$sell_order) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $sell_order->user_id = $request->user_id;
        $sell_order->seller_id = $request->seller_id;

        $sell_order->order_date = $request->order_date;
        $sell_order->penalty_desc = $request->penalty_desc;
        $sell_order->deadline = $request->deadline;

        $sell_order->address = $request->address;
        $sell_order->latitude = $request->latitude;
        $sell_order->longitude = $request->longitude;

        $sell_order->gcv_arb_min = $request->gcv_arb_min;
        $sell_order->gcv_arb_max = $request->gcv_arb_max;
        $sell_order->gcv_arb_reject = $request->gcv_arb_reject;
        $sell_order->gcv_arb_bonus = $request->gcv_arb_bonus;
        $sell_order->gcv_adb_min = $request->gcv_adb_min;
        $sell_order->gcv_adb_max = $request->gcv_adb_max;
        $sell_order->gcv_adb_reject = $request->gcv_adb_reject;
        $sell_order->gcv_adb_bonus = $request->gcv_adb_bonus;
        $sell_order->ncv_min = $request->ncv_min;
        $sell_order->ncv_max = $request->ncv_max;
        $sell_order->ncv_reject = $request->ncv_reject;
        $sell_order->ncv_bonus = $request->ncv_bonus;
        $sell_order->ash_min = $request->ash_min;
        $sell_order->ash_max = $request->ash_max;
        $sell_order->ash_reject = $request->ash_reject;
        $sell_order->ash_bonus = $request->ash_bonus;
        $sell_order->ts_min = $request->ts_min;
        $sell_order->ts_max = $request->ts_max;
        $sell_order->ts_reject = $request->ts_reject;
        $sell_order->ts_bonus = $request->ts_bonus;
        $sell_order->tm_min = $request->tm_min;
        $sell_order->tm_max = $request->tm_max;
        $sell_order->tm_reject = $request->tm_reject;
        $sell_order->tm_bonus = $request->tm_bonus;
        $sell_order->im_min = $request->im_min;
        $sell_order->im_max = $request->im_max;
        $sell_order->im_reject = $request->im_reject;
        $sell_order->im_bonus = $request->im_bonus;
        $sell_order->fc_min = $request->fc_min;
        $sell_order->fc_max = $request->fc_max;
        $sell_order->fc_reject = $request->fc_reject;
        $sell_order->fc_bonus = $request->fc_bonus;
        $sell_order->vm_min = $request->vm_min;
        $sell_order->vm_max = $request->vm_max;
        $sell_order->vm_reject = $request->vm_reject;
        $sell_order->vm_bonus = $request->vm_bonus;
        $sell_order->hgi_min = $request->hgi_min;
        $sell_order->hgi_max = $request->hgi_max;
        $sell_order->hgi_reject = $request->hgi_reject;
        $sell_order->hgi_bonus = $request->hgi_bonus;
        $sell_order->size_min = $request->size_min;
        $sell_order->size_max = $request->size_max;
        $sell_order->size_reject = $request->size_reject;
        $sell_order->size_bonus = $request->size_bonus;

        $sell_order->volume = $request->volume;
        $sell_order->max_price = $request->max_price;
        
        $sell_order->status = 'a';

        $sell_order->save();

        return response()->json($sell_order, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SellOrder $sell_order)
    {
        if (!$sell_order) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $sell_order->status = 'x';
        $sell_order->save();

        return response()->json($sell_order, 200);
    }
}
