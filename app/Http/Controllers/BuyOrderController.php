<?php

namespace App\Http\Controllers;

use App\Model\BuyOrder;

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

        $buy_order = BuyOrder::where('status', 'a')->get();
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

        $buy_order->user_id = $request->user_id;
        $buy_order->buyer_id = $request->buyer_id;

        $buy_order->order_date = $request->order_date;
        $buy_order->penalty_desc = $request->penalty_desc;
        $buy_order->deadline = $request->deadline;

        $buy_order->address = $request->address;
        $buy_order->latitude = $request->latitude;
        $buy_order->longitude = $request->longitude;

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

        $buy_order->status = 'a';

        $buy_order->save();

        // $activity = $this->storeActivity($buy_order->buyer_id, 'create', 'BuyOrder', $buy_order->id);

        return response()->json($buy_order, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($buy_order)
    {
        $buy_order = BuyOrder::find($buy_order);

        if($buy_order->status == 'a') {
            return response()->json([
                'success' => TRUE,
                $buy_order
                ], 200);
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
    public function update(Request $request, $buy_order)
    {
        $buy_order = BuyOrder::find($buy_order);
     
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

        $buy_order->user_id = $request->user_id;
        $buy_order->buyer_id = $request->buyer_id;

        $buy_order->order_date = $request->order_date;
        $buy_order->penalty_desc = $request->penalty_desc;
        $buy_order->deadline = $request->deadline;

        $buy_order->address = $request->address;
        $buy_order->latitude = $request->latitude;
        $buy_order->longitude = $request->longitude;

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
        
        $buy_order->status = 'a';

        $buy_order->save();

        return response()->json($buy_order, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($buy_order)
    {
        $buy_order = BuyOrder::find($buy_order);

        if (!$buy_order) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $buy_order->status = 'x';
        $buy_order->save();

        return response()->json($buy_order, 200);
    }

    // public function indexDetailed () {
    //     $buy_order = BuyOrder::with()
    // }
}
