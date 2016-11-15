<?php

namespace App\Http\Controllers;

use App\Model\BuyOrder;
use App\Model\SellOrder;
use App\Model\Buyer;
use App\Model\User;
use Auth;
use DB;
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
    public function index(Request $request)
    {
        if($request->order&&$request->order_id!==null){
            $user_id = Auth::User()->id;
            $sell_order = SellOrder::find($request->order_id)->first();
            $buy_order = BuyOrder::with('Buyer','User','trader')
            ->where([['order_status', 'v'],[DB::raw('DATEDIFF(ready_date,"'.$sell_order->ready_date.'")'),'>=',-7],[DB::raw('DATEDIFF(order_deadline,"'.$sell_order->order_deadline.'")'),'<=',7]])
            ->orwhere([['order_status', 'l'],[DB::raw('DATEDIFF(ready_date,"'.$sell_order->ready_date.'")'),'>=',-7],[DB::raw('DATEDIFF(order_deadline,"'.$sell_order->order_deadline.'")'),'<=',7]])
            ->orwhere([['order_status', 'p'],[DB::raw('DATEDIFF(ready_date,"'.$sell_order->ready_date.'")'),'>=',-7],[DB::raw('DATEDIFF(order_deadline,"'.$sell_order->order_deadline.'")'),'<=',7]])
            ->select('sell_order.*', 
                DB::raw('ABS(buy_order.gcv_adb_min-'.$sell_order->gcv_adb_min.') as gcv_adb_min_diff'), 
                DB::raw('ABS(buy_order.gcv_adb_max-'.$sell_order->gcv_adb_max.') as gcv_adb_max_diff'),
                DB::raw('ABS(buy_order.gcv_arb_min-'.$sell_order->gcv_arb_min.') as gcv_arb_min_diff'), 
                DB::raw('ABS(buy_order.gcv_arb_max-'.$sell_order->gcv_arb_max.') as gcv_arb_max_diff'), 
                DB::raw('ABS(buy_order.ncv_min-'.$sell_order->ncv_min.') as ncv_min_diff'), 
                DB::raw('ABS(buy_order.ncv_max-'.$sell_order->ncv_max.') as ncv_max_diff'), 
                DB::raw('ABS(buy_order.volume-'.$sell_order->volume.') as volume_diff'),
                DB::raw('DATEDIFF(ready_date,"'.$sell_order->ready_date.'") as ready_date_diff'),
                DB::raw('DATEDIFF(order_deadline,"'.$sell_order->order_deadline.'") as order_deadline_diff'))
            ->orderBy('gcv_adb_min_diff','asc')
            ->orderBy('gcv_adb_max_diff','asc')
            ->orderBy('gcv_arb_min_diff','asc')
            ->orderBy('gcv_arb_max_diff','asc')
            ->orderBy('ncv_min_diff','asc')
            ->orderBy('ncv_max_diff','asc')
            ->orderBy('volume_diff','asc')
            ->orderBy('ready_date_diff','asc')
            ->orderBy('order_deadline_diff','asc')
            ->orderBy('max_price','desc')
            ->get();
        }
        else if(!$request->order){
            $user_id = Auth::User()->id;
            $buy_order = BuyOrder::with('Buyer','User','trader')->where([['order_status', '1'], ['user_id', $user_id],])->orwhere([['order_status', '2'], ['user_id', $user_id],])->orwhere([['order_status', '3'], ['user_id', $user_id],])->orwhere([['order_status', '4'], ['user_id', $user_id],])->orwhere('order_status', 'v')->orwhere('order_status', 'l')->orwhere('order_status', 's')->orwhere('order_status', 'p')->get();
        }
        else if($request->order){
            $user_id = Auth::User()->id;
            $buy_order = BuyOrder::with('Buyer','User','trader')->where([['order_status', '1'], ['user_id', $user_id],])->orwhere([['order_status', '2'], ['user_id', $user_id],])->orwhere([['order_status', '3'], ['user_id', $user_id],])->orwhere([['order_status', '4'], ['user_id', $user_id],])->orwhere('order_status', 'v')->orwhere('order_status', 'l')->orwhere('order_status', 's')->orwhere('order_status', 'p')->get();
        }
        
        return response()->json($buy_order, 200);
    }

    /*
    *   SHOW ALL LEADS THAT ARE APPROVED IN AN ORDER BUT DIDN'T HAVE ANY MATCH
    */
    public function showApprovedLeads() {
        $buy_order = [];
        $query = BuyOrder::with('Buyer','User','trader', 'orders', 'orders.buys')->get();

        dd($query);

        foreach($query as $q) {
            if(count(array_pluck($q, 'orders.id')) < 2 && count(array_pluck($q, 'orders.id')) > 0) {
                // if(count(array_pluck($q->orders, 'buys.id')) < 2 && count(array_pluck($q->orders, 'buys.id')) > 0 && count(array_pluck($q->orders, 'sells.id')) < 1) {
                    array_push($buy_order, $q);
                // }
            }
        }

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

        $buy_order->factory_id = $request->factory_id;
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
        $buy_order->typical_quality = $request->typical_quality;
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
        $buy_order->fe2o3_min = $request->fe2o3_min;
        $buy_order->fe2o3_max = $request->fe2o3_max;
        $buy_order->fe2o3_reject = $request->fe2o3_reject;
        $buy_order->fe2o3_bonus = $request->fe2o3_bonus;
        $buy_order->aft_min = $request->aft_min;
        $buy_order->aft_max = $request->aft_max;
        $buy_order->aft_reject = $request->aft_reject;
        $buy_order->aft_bonus = $request->aft_bonus;

        $buy_order->volume = $request->volume;
        $buy_order->max_price = $request->max_price;
        $buy_order->trading_term = $request->trading_term;
        $buy_order->trading_term_detail = $request->trading_term_detail;
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
        $subordinates = $this->getSub();
        foreach ($subordinates as $sub ) {
            $lower[] = $sub->id;
        }
        $lower[] = Auth::User()->id;
        $buy_order = BuyOrder::with('Buyer','Port','Factory', 'orders')->find($id);
        $buy_order2 = BuyOrder::with('Port','Factory', 'orders')->where('id',$id)->select('id', 'user_id', 'buyer_id', 'order_date', 'order_deadline', 'ready_date', 'expired_date', 'factory_id', 'city', 'country', 'latitude', 'longitude', 'port_distance', 'port_id', 'port_name', 'port_status', 'port_daily_rate', 'port_draft_height', 'port_latitude', 'port_longitude', DB::raw('NULL as product_name') , 'typical_quality', 'product_id', 'gcv_arb_min', 'gcv_arb_max', 'gcv_arb_reject', 'gcv_arb_bonus', 'gcv_adb_min', 'gcv_adb_max', 'gcv_adb_reject', 'gcv_adb_bonus', 'ncv_min', 'ncv_max', 'ncv_reject', 'ncv_bonus', 'ash_min', 'ash_max', 'ash_reject', 'ash_bonus', 'ts_min', 'ts_max', 'ts_reject', 'ts_bonus', 'tm_min', 'tm_max', 'tm_reject', 'tm_bonus', 'im_min', 'im_max', 'im_reject', 'im_bonus', 'fc_min', 'fc_max', 'fc_reject', 'fc_bonus', 'vm_min', 'vm_max', 'vm_reject', 'vm_bonus', 'hgi_min', 'hgi_max', 'hgi_reject', 'hgi_bonus', 'size_min', 'size_max', 'size_reject', 'size_bonus', 'fe2o3_min', 'fe2o3_max', 'fe2o3_reject', 'fe2o3_bonus', 'aft_min', 'aft_max', 'aft_reject', 'aft_bonus', 'volume', 'max_price', 'trading_term', 'trading_term_detail', 'payment_terms', 'commercial_term', 'penalty_desc', 'order_status', 'progress_status', 'created_at', 'updated_at')->first();

        //if order.user_id subordinate or self get product_name
        if(($buy_order->order_status == 'v' || $buy_order->order_status == 1 || $buy_order->order_status == 2 || $buy_order->order_status == 3 || $buy_order->order_status == 4 || $buy_order->order_status == 'l' || $buy_order->order_status == 's' || $buy_order->order_status == 'p')&&(in_array($buy_order->user_id, $lower))) {
            return response()->json($buy_order, 200);
        }
        //if order.user_id not subordinate or self product_name = NULL
        else if(($buy_order->order_status == 'v' || $buy_order->order_status == 1 || $buy_order->order_status == 2 || $buy_order->order_status == 3 || $buy_order->order_status == 4 || $buy_order->order_status == 'l' || $buy_order->order_status == 's' || $buy_order->order_status == 'p')&&(in_array($buy_order->user_id, $lower)===false)) {
            return response()->json($buy_order2, 200);
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

        $buy_order->factory_id = $request->factory_id;
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
        $buy_order->typical_quality = $request->typical_quality;
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
        $buy_order->fe2o3_min = $request->fe2o3_min;
        $buy_order->fe2o3_max = $request->fe2o3_max;
        $buy_order->fe2o3_reject = $request->fe2o3_reject;
        $buy_order->fe2o3_bonus = $request->fe2o3_bonus;
        $buy_order->aft_min = $request->aft_min;
        $buy_order->aft_max = $request->aft_max;
        $buy_order->aft_reject = $request->aft_reject;
        $buy_order->aft_bonus = $request->aft_bonus;

        $buy_order->volume = $request->volume;
        $buy_order->max_price = $request->max_price;
        $buy_order->trading_term = $request->trading_term;
        $buy_order->trading_term_detail = $request->trading_term_detail;
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
            $subordinates = $this->getSub();
            foreach ($subordinates as $sub ) {
                $lower[] = $sub->id;
            }
            $lower[] = Auth::User()->id;
            $buy_order = BuyOrder::join('users', 'buy_order.user_id', '=', 'users.id')->join('buyers', 'buy_order.buyer_id', '=', 'buyers.id')->where('order_status', $order_status)->whereIn('buy_order.user_id', $lower)->select('buy_order.id', 'buy_order.user_id', 'order_date', 'order_deadline', 'expired_date', 'buy_order.address', 'buy_order.city', 'buy_order.country', DB::raw('NULL as product_name') , 'typical_quality', 'volume', 'max_price', 'order_status', 'users.name', 'company_name');
            $buy_order2 = BuyOrder::join('users', 'buy_order.user_id', '=', 'users.id')->where('order_status', $order_status)->whereNotIn('user_id', $lower)->select('buy_order.id', 'user_id', 'order_date', 'order_deadline', 'expired_date', 'address', 'city', 'country', DB::raw('NULL as product_name') , 'typical_quality', 'volume', 'max_price', 'order_status', 'users.name', DB::raw('NULL as company_name'));
            // foreach ($buy_order2 as $buy) {
            //     $buy->buyer = [];
            // }
            $buy_order = $buy_order2->union($buy_order)->get();
        } else {
            $buy_orders = BuyOrder::with('Buyer','User')->where('order_status', $order_status)->where('progress_status', 'LIKE', '%'.$progress_status.'%')->get();
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

    public function draft($user_id)
    {
        $buy_order = BuyOrder::with('Buyer','User')
        ->where([['order_status', '1'], ['user_id', $user_id],])
        ->orwhere([['order_status', '2'], ['user_id', $user_id],])
        ->orwhere([['order_status', '3'], ['user_id', $user_id],])
        ->orwhere([['order_status', '4'], ['user_id', $user_id],])
        ->orwhere([['order_status', '0'], ['user_id', $user_id],])
        ->get();
        return response()->json($buy_order, 200);
    }

    public function getSub(){
        $user = Auth::User();
        return $user->getAllSubordinates();
    }

    public function getManager(){
        $user = Auth::User();
        return $user->getAllManagers();
    }


}
