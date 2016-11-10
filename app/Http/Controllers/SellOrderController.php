<?php

namespace App\Http\Controllers;

use App\Model\SellOrder;
use App\Model\Seller;
use Auth;
use DB;

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
        $sell_order = SellOrder::with('Seller','User')->where('order_status', 1)->orwhere('order_status', 2)->orwhere('order_status', 3)->orwhere('order_status', 4)->orwhere('order_status', 'v')->orwhere('order_status', 'l')->orwhere('order_status', 's')->orwhere('order_status', 'p')->get();

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

        $sell_order->user_id = Auth::User()->id;
        $sell_order->seller_id = $request->seller_id;

        $sell_order->order_date = date('Y-m-d',strtotime($request->order_date));
        $sell_order->order_deadline = date('Y-m-d',strtotime($request->order_deadline));
        $sell_order->ready_date = date('Y-m-d',strtotime($request->ready_date));
        $sell_order->expired_date = date('Y-m-d',strtotime($request->expired_date));

        $sell_order->address = $request->address;
        $sell_order->city = $request->city;
        $sell_order->country = $request->country;
        $sell_order->latitude = $request->latitude;
        $sell_order->longitude = $request->longitude;
        $sell_order->port_distance = $request->port_distance;
        $sell_order->port_id = $request->port_id;
        $sell_order->port_name = $request->port_name;
        $sell_order->port_status = $request->port_status;
        $sell_order->port_daily_rate = $request->port_daily_rate;
        $sell_order->port_draft_height = $request->port_draft_height;
        $sell_order->port_latitude = $request->port_latitude;
        $sell_order->port_longitude = $request->port_longitude;

        $sell_order->product_name = $request->product_name;
        $sell_order->typical_quality = $request->typical_quality;
        $sell_order->product_id = $request->product_id;

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
        $sell_order->fe2o3_min = $request->fe2o3_min;
        $sell_order->fe2o3_max = $request->fe2o3_max;
        $sell_order->fe2o3_reject = $request->fe2o3_reject;
        $sell_order->fe2o3_bonus = $request->fe2o3_bonus;
        $sell_order->aft_min = $request->aft_min;
        $sell_order->aft_max = $request->aft_max;
        $sell_order->aft_reject = $request->aft_reject;
        $sell_order->aft_bonus = $request->aft_bonus;

        $sell_order->volume = $request->volume;
        $sell_order->min_price = $request->min_price;
        $sell_order->trading_term = $request->trading_term;
        $sell_order->payment_terms = $request->payment_terms;
        $sell_order->commercial_term = $request->commercial_term;
        $sell_order->penalty_desc = $request->penalty_desc;
        
        $sell_order->order_status = '1';
        $sell_order->progress_status = $request->progress_status;
        
        $sell_order->save();

        $seller = Seller::find($request->seller_id);
        $sell_order->seller = $seller;

        $sell_order->order_date = $request->order_date;
        $sell_order->order_deadline = $request->order_deadline;
        $sell_order->ready_date = $request->ready_date;
        $sell_order->expired_date = $request->expired_date;

        return response()->json($sell_order, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sell_order = SellOrder::with('Seller','Port','Concession')->find($id);

        if($sell_order->order_status == 'v' || $sell_order->order_status == 1 || $sell_order->order_status == 2 || $sell_order->order_status == 3 || $sell_order->order_status == 4 || $sell_order->order_status == 'l' || $sell_order->order_status == 's' || $sell_order->order_status == 'p') {
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
    public function update(Request $request, $id)
    {
        $sell_order = SellOrder::find($id);

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

        $sell_order->user_id = Auth::User()->id;
        $sell_order->seller_id = $request->seller_id;

        $sell_order->order_date = date('Y-m-d',strtotime($request->order_date));
        $sell_order->order_deadline = date('Y-m-d',strtotime($request->order_deadline));
        $sell_order->ready_date = date('Y-m-d',strtotime($request->ready_date));
        $sell_order->expired_date = date('Y-m-d',strtotime($request->expired_date));

        $sell_order->concession_id = $request->concession_id;
        $sell_order->address = $request->address;
        $sell_order->city = $request->city;
        $sell_order->country = $request->country;
        $sell_order->latitude = $request->latitude;
        $sell_order->longitude = $request->longitude;
        $sell_order->port_distance = $request->port_distance;
        $sell_order->port_id = $request->port_id;
        $sell_order->port_name = $request->port_name;
        $sell_order->port_status = $request->port_status;
        $sell_order->port_daily_rate = $request->port_daily_rate;
        $sell_order->port_draft_height = $request->port_draft_height;
        $sell_order->port_latitude = $request->port_latitude;
        $sell_order->port_longitude = $request->port_longitude;

        $sell_order->product_name = $request->product_name;
        $sell_order->typical_quality = $request->typical_quality;
        $sell_order->product_id = $request->product_id;

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
        $sell_order->fe2o3_min = $request->fe2o3_min;
        $sell_order->fe2o3_max = $request->fe2o3_max;
        $sell_order->fe2o3_reject = $request->fe2o3_reject;
        $sell_order->fe2o3_bonus = $request->fe2o3_bonus;
        $sell_order->aft_min = $request->aft_min;
        $sell_order->aft_max = $request->aft_max;
        $sell_order->aft_reject = $request->aft_reject;
        $sell_order->aft_bonus = $request->aft_bonus;

        $sell_order->volume = $request->volume;
        $sell_order->min_price = $request->min_price;
        $sell_order->trading_term = $request->trading_term;
        $sell_order->payment_terms = $request->payment_terms;
        $sell_order->commercial_term = $request->commercial_term;
        $sell_order->penalty_desc = $request->penalty_desc;
        
        $sell_order->order_status = $request->order_status;
        $sell_order->progress_status = $request->progress_status;

        $sell_order->save();

        $sell_order->order_date = $request->order_date;
        $sell_order->order_deadline = $request->order_deadline;
        $sell_order->ready_date = $request->ready_date;
        $sell_order->expired_date = $request->expired_date;

        return response()->json($sell_order, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sell_order = SellOrder::find($id);
        
        if (!$sell_order) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $sell_order->status = 'x';
        $sell_order->save();

        return response()->json($sell_order, 200);
    }

    public function status($order_status, $progress_status = false)
    {
        if (!$progress_status) {
            $subordinates = $this->getSub();
            foreach ($subordinates as $sub ) {
                $lower[] = $sub->id;
            }
            $lower[] = Auth::User()->id;
            $sell_order = SellOrder::with('Seller','User')->where('order_status', $order_status)->whereIn('user_id', $lower);
            $sell_order2 = SellOrder::with('User')->where('order_status', $order_status)->whereNotIn('user_id', $lower)->select('id', 'user_id', 'seller_id', 'order_date', 'order_deadline', 'ready_date', 'expired_date', 'concession_id', 'address', 'city', 'country', 'latitude', 'longitude', 'port_distance', 'port_id', 'port_name', 'port_status', 'port_daily_rate', 'port_draft_height', 'port_latitude', 'port_longitude', DB::raw('NULL as product_name') , 'typical_quality', 'product_id', 'gcv_arb_min', 'gcv_arb_max', 'gcv_arb_reject', 'gcv_arb_bonus', 'gcv_adb_min', 'gcv_adb_max', 'gcv_adb_reject', 'gcv_adb_bonus', 'ncv_min', 'ncv_max', 'ncv_reject', 'ncv_bonus', 'ash_min', 'ash_max', 'ash_reject', 'ash_bonus', 'ts_min', 'ts_max', 'ts_reject', 'ts_bonus', 'tm_min', 'tm_max', 'tm_reject', 'tm_bonus', 'im_min', 'im_max', 'im_reject', 'im_bonus', 'fc_min', 'fc_max', 'fc_reject', 'fc_bonus', 'vm_min', 'vm_max', 'vm_reject', 'vm_bonus', 'hgi_min', 'hgi_max', 'hgi_reject', 'hgi_bonus', 'size_min', 'size_max', 'size_reject', 'size_bonus', 'fe2o3_min', 'fe2o3_max', 'fe2o3_reject', 'fe2o3_bonus', 'aft_min', 'aft_max', 'aft_reject', 'aft_bonus', 'volume', 'min_price', 'trading_term', 'payment_terms', 'commercial_term', 'penalty_desc', 'order_status', 'progress_status', 'created_at', 'updated_at');
            $sell_order = $sell_order2->union($sell_order)->get();
        } else {
            $sell_order = SellOrder::with('Seller','User')->where('order_status', $order_status)->where('progress_status', 'LIKE', '%'.$progress_status.'%')->get();
        }

        return response()->json($sell_order, 200);
    }

    public function changeOrderStatus($id, $order_status)
    {
        $sell_order = SellOrder::find($id);
        
        if (!$sell_order) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        if ($order_status) {
          $sell_order->order_status = $order_status;
          $sell_order->save();
        }

        return response()->json($sell_order, 200);
    }

    public function draft($user_id)
    {
        $sell_order = SellOrder::with('Seller','User')
        ->where([['order_status', '1'], ['user_id', $user_id],])
        ->orwhere([['order_status', '2'], ['user_id', $user_id],])
        ->orwhere([['order_status', '3'], ['user_id', $user_id],])
        ->orwhere([['order_status', '4'], ['user_id', $user_id],])
        ->orwhere([['order_status', '0'], ['user_id', $user_id],])
        ->get();
        return response()->json($sell_order, 200);
    }

    public function getSub(){
        $user = Auth::User();
        return $user->getAllSubordinates();
    }
}
