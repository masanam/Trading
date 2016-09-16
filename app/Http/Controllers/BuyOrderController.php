<?php

namespace App\Http\Controllers;

use App\Model\BuyOrder;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Traits\ActivityTrait as Activity;

class BuyOrderController extends Controller
{
    use Activity;

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
        $BuyOrder = BuyOrder::where('status', 'a')->get();

        return response()->json($BuyOrder, 200);
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

        $BuyOrder = new BuyOrder();

        $BuyOrder->buyer_id = $request->buyer_id;

        $BuyOrder->order_date = $request->order_date;
        $BuyOrder->deadline = $request->deadline;

        $BuyOrder->address = $request->address;
        $BuyOrder->latitude = $request->latitude;
        $BuyOrder->longitude = $request->longitude;

        $BuyOrder->gcv_arb_min = $request->gcv_arb_min;
        $BuyOrder->gcv_arb_max = $request->gcv_arb_max;
        $BuyOrder->gcv_arb_reject = $request->gcv_arb_reject;
        $BuyOrder->gcv_arb_bonus = $request->gcv_arb_bonus;
        $BuyOrder->gcv_adb_min = $request->gcv_adb_min;
        $BuyOrder->gcv_adb_max = $request->gcv_adb_max;
        $BuyOrder->gcv_adb_reject = $request->gcv_adb_reject;
        $BuyOrder->gcv_adb_bonus = $request->gcv_adb_bonus;
        $BuyOrder->ncv_min = $request->ncv_min;
        $BuyOrder->ncv_max = $request->ncv_max;
        $BuyOrder->ncv_reject = $request->ncv_reject;
        $BuyOrder->ncv_bonus = $request->ncv_bonus;
        $BuyOrder->ash_min = $request->ash_min;
        $BuyOrder->ash_max = $request->ash_max;
        $BuyOrder->ash_reject = $request->ash_reject;
        $BuyOrder->ash_bonus = $request->ash_bonus;
        $BuyOrder->ts_min = $request->ts_min;
        $BuyOrder->ts_max = $request->ts_max;
        $BuyOrder->ts_reject = $request->ts_reject;
        $BuyOrder->ts_bonus = $request->ts_bonus;
        $BuyOrder->tm_min = $request->tm_min;
        $BuyOrder->tm_max = $request->tm_max;
        $BuyOrder->tm_reject = $request->tm_reject;
        $BuyOrder->tm_bonus = $request->tm_bonus;
        $BuyOrder->im_min = $request->im_min;
        $BuyOrder->im_max = $request->im_max;
        $BuyOrder->im_reject = $request->im_reject;
        $BuyOrder->im_bonus = $request->im_bonus;
        $BuyOrder->fc_min = $request->fc_min;
        $BuyOrder->fc_max = $request->fc_max;
        $BuyOrder->fc_reject = $request->fc_reject;
        $BuyOrder->fc_bonus = $request->fc_bonus;
        $BuyOrder->vm_min = $request->vm_min;
        $BuyOrder->vm_max = $request->vm_max;
        $BuyOrder->vm_reject = $request->vm_reject;
        $BuyOrder->vm_bonus = $request->vm_bonus;
        $BuyOrder->hgi_min = $request->hgi_min;
        $BuyOrder->hgi_max = $request->hgi_max;
        $BuyOrder->hgi_reject = $request->hgi_reject;
        $BuyOrder->hgi_bonus = $request->hgi_bonus;
        $BuyOrder->size_min = $request->size_min;
        $BuyOrder->size_max = $request->size_max;
        $BuyOrder->size_reject = $request->size_reject;
        $BuyOrder->size_bonus = $request->size_bonus;

        $BuyOrder->volume = $request->volume;
        
        $BuyOrder->status = 'a';

        $BuyOrder->save();

        $activity = $this->storeActivity($BuyOrder->buyer_id, 'create', 'BuyOrder', $BuyOrder->id);

        return response()->json($BuyOrder, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BuyOrder $BuyOrder)
    {
        if($BuyOrder->status == 'a') {
            return response()->json($BuyOrder, 200);
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
    public function update(Request $request, BuyOrder $BuyOrder)
    {
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$BuyOrder) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $BuyOrder->name = $request->name;
        $BuyOrder->image = $request->image;
        $BuyOrder->title = $request->title;
        $BuyOrder->email = $request->email;
        $BuyOrder->phone = $request->phone;

        $BuyOrder->save();

        return response()->json($BuyOrder, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BuyOrder $BuyOrder)
    {
        if (!$BuyOrder) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $BuyOrder->status = 'x';
        $BuyOrder->save();

        return response()->json($BuyOrder, 200);
    }
}
