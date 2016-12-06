<?php

namespace App\Http\Controllers;

use App\Model\Buyer;
use App\Model\Seller;
use App\Model\Vendor;
use App\Model\Contact;
use App\Model\BuyOrder;
use App\Model\SellOrder;;
use App\Model\Product;
use Auth;
use DB;

use Illuminate\Http\Request;

use App\Http\Requests;

class LeadController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        if ($request->type === 'buy') {
            
            if($request->order&&$request->order_id!==null){
                $user_id = Auth::User()->id;
                $buy_order = BuyOrder::where('id',$request->order_id)->first();
                $sell_order = SellOrder::with('Seller','User','trader','used')
                    ->where([
                        ['order_status', 'v'],
                        [DB::raw('DATEDIFF(ready_date,"'.$buy_order->ready_date.'")'),'>=',-7],
                        [DB::raw('DATEDIFF(order_deadline,"'.$buy_order->order_deadline.'")'),'<=',7]
                    ])
                    ->orwhere([
                        ['order_status', 'l'],
                        [DB::raw('DATEDIFF(ready_date,"'.$buy_order->ready_date.'")'),'>=',-7],
                        [DB::raw('DATEDIFF(order_deadline,"'.$buy_order->order_deadline.'")'),'<=',7]
                    ])
                    ->orwhere([
                        ['order_status', 'p'],
                        [DB::raw('DATEDIFF(ready_date,"'.$buy_order->ready_date.'")'),'>=',-7],
                        [DB::raw('DATEDIFF(order_deadline,"'.$buy_order->order_deadline.'")'),'<=',7]
                    ])
                    ->select('sell_order.*',  
                        DB::raw('ABS(sell_order.gcv_adb_min-'.$buy_order->gcv_adb_min.') as gcv_adb_min_diff'), 
                        DB::raw('ABS(sell_order.gcv_adb_max-'.$buy_order->gcv_adb_max.') as gcv_adb_max_diff'),
                        DB::raw('ABS(sell_order.gcv_arb_min-'.$buy_order->gcv_arb_min.') as gcv_arb_min_diff'), 
                        DB::raw('ABS(sell_order.gcv_arb_max-'.$buy_order->gcv_arb_max.') as gcv_arb_max_diff'), 
                        DB::raw('ABS(sell_order.ncv_min-'.$buy_order->ncv_min.') as ncv_min_diff'), 
                        DB::raw('ABS(sell_order.ncv_max-'.$buy_order->ncv_max.') as ncv_max_diff'), 
                        DB::raw('ABS(sell_order.volume-'.$buy_order->volume.') as volume_diff'),
                        DB::raw('DATEDIFF(ready_date,"'.$buy_order->ready_date.'") as ready_date_diff'),
                        DB::raw('DATEDIFF(order_deadline,"'.$buy_order->order_deadline.'") as order_deadline_diff'))
                    ->orderBy('gcv_adb_min_diff','asc')
                    ->orderBy('gcv_adb_max_diff','asc')
                    ->orderBy('gcv_arb_min_diff','asc')
                    ->orderBy('gcv_arb_max_diff','asc')
                    ->orderBy('ncv_min_diff','asc')
                    ->orderBy('ncv_max_diff','asc')
                    ->orderBy('volume_diff','asc')
                    ->orderBy('ready_date_diff','asc')
                    ->orderBy('order_deadline_diff','asc')
                    ->orderBy('min_price','asc')
                    ->limit($request->limit)
                    ->get();
            }
            else if($request->supplier&&$request->order_id!==null){
                $buy_order = BuyOrder::where('id',$request->order_id)->first();
                $sell_order = Product::with('Seller')
                    ->where('buyer_id',null)
                    ->select('products.*',  
                        DB::raw('ABS(products.gcv_adb_min-'.$buy_order->gcv_adb_min.') as gcv_adb_min_diff'), 
                        DB::raw('ABS(products.gcv_adb_max-'.$buy_order->gcv_adb_max.') as gcv_adb_max_diff'),
                        DB::raw('ABS(products.gcv_arb_min-'.$buy_order->gcv_arb_min.') as gcv_arb_min_diff'), 
                        DB::raw('ABS(products.gcv_arb_max-'.$buy_order->gcv_arb_max.') as gcv_arb_max_diff'), 
                        DB::raw('ABS(products.ncv_min-'.$buy_order->ncv_min.') as ncv_min_diff'), 
                        DB::raw('ABS(products.ncv_max-'.$buy_order->ncv_max.') as ncv_max_diff'))
                    ->orderBy('gcv_adb_min_diff','asc')
                    ->orderBy('gcv_adb_max_diff','asc')
                    ->orderBy('gcv_arb_min_diff','asc')
                    ->orderBy('gcv_arb_max_diff','asc')
                    ->orderBy('ncv_min_diff','asc')
                    ->orderBy('ncv_max_diff','asc')
                    ->limit($request->limit)
                    ->get();
            }
            else if($request->order){
                $user_id = Auth::User()->id;
                $sell_order = SellOrder::with('Seller','User','trader','used')->where('order_status', 'v')->orwhere('order_status', 'l')->orwhere('order_status', 'p')->get();
            }

            //list lead status
            else if($request->order_status){
                if ($request->order_status!=='draft') {
                    $subordinates = $this->getSub();
                    foreach ($subordinates as $sub ) {
                        $lower[] = $sub->id;
                    }
                    $lower[] = Auth::User()->id;
                    $sell_order = SellOrder::leftJoin('users', 'sell_order.user_id', '=', 'users.id')
                        ->leftJoin('sellers', 'sell_order.seller_id', 'sellers.id')
                        ->leftJoin('order_details', function ($join) {
                            $join->on('order_details.orderable_id', 'sell_order.id')
                                 ->where('orderable_type', '=', 'App\Model\SellOrder');
                        })
                        ->leftJoin('orders', function ($join) {
                            $join->on('order_details.order_id', 'orders.id')
                                 ->whereIn('orders.status', ['a', 'p', 'f']);
                        })
                        ->where('order_status', $request->order_status)
                        ->whereIn('sell_order.user_id', $lower)
                        ->select(
                            'sell_order.id', 'sell_order.user_id', 'order_date', 'order_deadline',
                            'expired_date', 'sell_order.address', 'sell_order.city', 'sell_order.country',
                            DB::raw('NULL as product_name') ,
                            DB::raw('IFNULL(SUM(order_details.volume),0) as used_volume'),
                            'typical_quality', 'sell_order.volume', 'min_price', 'order_status', 'users.name', 'company_name'
                        )
                        ->groupBy('sell_order.id', 'orders.id');

                    $sell_order2 = SellOrder::leftJoin('users', 'sell_order.user_id', '=', 'users.id')
                        ->leftJoin('order_details', function ($join) {
                            $join->on('order_details.orderable_id', 'sell_order.id')
                                 ->where('orderable_type', 'App\Model\SellOrder');
                        })
                        ->join('orders', function ($join) {
                            $join->on('order_details.order_id', 'orders.id')
                                 ->whereIn('orders.status', ['a', 'p', 'f']);
                        })
                        ->where('order_status', $request->order_status)
                        ->whereNotIn('sell_order.user_id', $lower)
                        ->select(
                            'sell_order.id', 'sell_order.user_id', 'order_date', 'order_deadline',
                            'expired_date', 'address','city', 'country', 
                            DB::raw('NULL as product_name'),
                            DB::raw('SUM(order_details.volume) as used_volume'),
                            'typical_quality', 'sell_order.volume', 'min_price', 'order_status', 'users.name',
                            DB::raw('NULL as company_name')
                        )->groupBy('sell_order.id', 'orders.id');

                    $sell_order = $sell_order2->union($sell_order)->get();
                } else if($request->order_status==='draft') {
                    $sell_order = SellOrder::with('Seller','User')
                        ->where([['order_status', '1'], ['user_id', Auth::User()->id],])
                        ->orwhere([['order_status', '2'], ['user_id', Auth::User()->id],])
                        ->orwhere([['order_status', '3'], ['user_id', Auth::User()->id],])
                        ->orwhere([['order_status', '4'], ['user_id', Auth::User()->id],])
                        ->orwhere([['order_status', '0'], ['user_id', Auth::User()->id],])
                        ->get();
                } else if($request->order_status==='all'){
                    $user_id = Auth::User()->id;
                    $sell_order = SellOrder::with('Seller','User','trader','used')
                        ->where([['order_status', '1'], ['user_id', $user_id],])
                        ->orwhere([['order_status', '2'], ['user_id', $user_id],])
                        ->orwhere([['order_status', '3'], ['user_id', $user_id],])
                        ->orwhere([['order_status', '4'], ['user_id', $user_id],])
                        ->orwhere('order_status', 'v')
                        ->orwhere('order_status', 'l')
                        ->orwhere('order_status', 's')
                        ->orwhere('order_status', 'p')
                        ->get();
                }
            }
            
            return response()->json($sell_order, 200);

        }
        else if ($request->type === 'sell') {

            if($request->order&&$request->order_id!==null){
                $user_id = Auth::User()->id;
                $sell_order = SellOrder::where('id',$request->order_id)->first();
                $buy_order = BuyOrder::with('Buyer','User','trader','used')
                    ->where([['order_status', 'v'],
                        [DB::raw('DATEDIFF(ready_date,"'.$sell_order->ready_date.'")'),'>=',-7],
                        [DB::raw('DATEDIFF(order_deadline,"'.$sell_order->order_deadline.'")'),'<=',7]])
                    ->orwhere([['order_status', 'l'],
                        [DB::raw('DATEDIFF(ready_date,"'.$sell_order->ready_date.'")'),'>=',-7],
                        [DB::raw('DATEDIFF(order_deadline,"'.$sell_order->order_deadline.'")'),'<=',7]])
                    ->orwhere([['order_status', 'p'],
                        [DB::raw('DATEDIFF(ready_date,"'.$sell_order->ready_date.'")'),'>=',-7],
                        [DB::raw('DATEDIFF(order_deadline,"'.$sell_order->order_deadline.'")'),'<=',7]])
                    ->select('buy_order.*', 
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
                    ->limit($request->limit)
                    ->get();
            }
            else if($request->customer&&$request->order_id!==null){
                $sell_order = SellOrder::where('id',$request->order_id)->first();
                $buy_order = Product::with('Buyer')
                    ->where('seller_id',null)
                    ->select('products.*', 
                        DB::raw('ABS(products.gcv_adb_min-'.$sell_order->gcv_adb_min.') as gcv_adb_min_diff'), 
                        DB::raw('ABS(products.gcv_adb_max-'.$sell_order->gcv_adb_max.') as gcv_adb_max_diff'),
                        DB::raw('ABS(products.gcv_arb_min-'.$sell_order->gcv_arb_min.') as gcv_arb_min_diff'), 
                        DB::raw('ABS(products.gcv_arb_max-'.$sell_order->gcv_arb_max.') as gcv_arb_max_diff'), 
                        DB::raw('ABS(products.ncv_min-'.$sell_order->ncv_min.') as ncv_min_diff'), 
                        DB::raw('ABS(products.ncv_max-'.$sell_order->ncv_max.') as ncv_max_diff'))
                    ->orderBy('gcv_adb_min_diff','asc')
                    ->orderBy('gcv_adb_max_diff','asc')
                    ->orderBy('gcv_arb_min_diff','asc')
                    ->orderBy('gcv_arb_max_diff','asc')
                    ->orderBy('ncv_min_diff','asc')
                    ->orderBy('ncv_max_diff','asc')
                    ->limit($request->limit)
                    ->get();
            }
            else if(!$request->order){
                $user_id = Auth::User()->id;
                $buy_order = BuyOrder::with('Buyer','User','trader','used')
                    ->where([['order_status', '1'], ['user_id', $user_id],])
                    ->orwhere([['order_status', '2'], ['user_id', $user_id],])
                    ->orwhere([['order_status', '3'], ['user_id', $user_id],])
                    ->orwhere([['order_status', '4'], ['user_id', $user_id],])
                    ->orwhere('order_status', 'v')
                    ->orwhere('order_status', 'l')
                    ->orwhere('order_status', 's')
                    ->orwhere('order_status', 'p')
                    ->get();
            }
            else if($request->order){
                $user_id = Auth::User()->id;
                $buy_order = BuyOrder::with('Buyer','User','trader','used')->where('order_status', 'v')->orwhere('order_status', 'l')->orwhere('order_status', 'p')->get();
                $arrays = [];
                foreach($buy_order as $object)
                {
                    $arrays[] =  (array) $object;
                }
                array_merge($arrays, $this->showApprovedLeads());
            }

            return response()->json($buy_order, 200);

        }
    }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
    public function store(Request $request){
        if(!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if ($request->type === 'buy') {
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
            $sell_order->trading_term_detail = $request->trading_term_detail;
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
        else if ($request->type === 'sell') {

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
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id){
        
        if ($request->type === 'buy'){
            $subordinates = $this->getSub();
            foreach ($subordinates as $sub ) {
                $all_access[] = $sub->id;
            }
            $all_access[] = Auth::User()->id;

            $sell_order = SellOrder::with('Seller','Port','Concession', 'orders')
                ->find($id);

            if($sell_order->order_status == 'x')
                return response()->json(['message'=>'deactivated record'], 404);

            if(!in_array($sell_order->user_id, $all_access)){
                $sell_order->cleanse();
            }

            return response()->json($sell_order, 200);
        }
        else if ($request->type === 'sell') {
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
    
    }

    public function update(Request $request, $id){
        if ($request->type === 'buy'){
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
        else if ($request->type === 'sell'){
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
            $sell_order->trading_term_detail = $request->trading_term_detail;
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

    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($buyer){
        if ($request->type === 'buy'){
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
        else if ($request->type === 'sell'){
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
