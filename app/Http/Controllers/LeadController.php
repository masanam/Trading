<?php

namespace App\Http\Controllers;

use App\Model\Buyer;
use App\Model\Seller;
use App\Model\Vendor;
use App\Model\Contact;
use App\Model\BuyOrder;
use App\Model\SellOrder;
use App\Model\Company;
use App\Model\Lead;
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
                $sell_order = SellOrder::with('Company','User','trader','used')
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
                $sell_order = Product::with('Company')
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
                $sell_order = SellOrder::with('Company','User','trader','used')->where('order_status', 'v')->orwhere('order_status', 'l')->orwhere('order_status', 'p')->get();
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
                    $sell_order = SellOrder::with('Company','User')
                        ->where([['order_status', '1'], ['user_id', Auth::User()->id],])
                        ->orwhere([['order_status', '2'], ['user_id', Auth::User()->id],])
                        ->orwhere([['order_status', '3'], ['user_id', Auth::User()->id],])
                        ->orwhere([['order_status', '4'], ['user_id', Auth::User()->id],])
                        ->orwhere([['order_status', '0'], ['user_id', Auth::User()->id],])
                        ->get();
                } else if($request->order_status==='all'){
                    $user_id = Auth::User()->id;
                    $sell_order = SellOrder::with('Company','User','trader','used')
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

        $lead = new Lead();
        $lead->user_id = Auth::User()->id;
        $lead->company_id = $request->company_id;

        if ($request->lead_type === 'buy') {
            $lead->lead_type = 'b';
        }
        else if ($request->lead_type === 'sell') {
            $lead->lead_type = 's';
        }
        $lead->order_date = date('Y-m-d',strtotime($request->order_date));
        $lead->order_deadline = date('Y-m-d',strtotime($request->order_deadline));
        $lead->ready_date = date('Y-m-d',strtotime($request->ready_date));
        $lead->expired_date = date('Y-m-d',strtotime($request->expired_date));

        $lead->address = $request->address;
        $lead->city = $request->city;
        $lead->country = $request->country;
        $lead->latitude = $request->latitude;
        $lead->longitude = $request->longitude;
        $lead->port_distance = $request->port_distance;
        $lead->port_id = $request->port_id;
        $lead->port_name = $request->port_name;
        $lead->port_status = $request->port_status;
        $lead->port_daily_rate = $request->port_daily_rate;
        $lead->port_draft_height = $request->port_draft_height;
        $lead->port_latitude = $request->port_latitude;
        $lead->port_longitude = $request->port_longitude;

        $lead->product_name = $request->product_name;
        $lead->typical_quality = $request->typical_quality;
        $lead->product_id = $request->product_id;

        $lead->gcv_arb_min = $request->gcv_arb_min;
        $lead->gcv_arb_max = $request->gcv_arb_max;
        $lead->gcv_arb_reject = $request->gcv_arb_reject;
        $lead->gcv_arb_bonus = $request->gcv_arb_bonus;
        $lead->gcv_adb_min = $request->gcv_adb_min;
        $lead->gcv_adb_max = $request->gcv_adb_max;
        $lead->gcv_adb_reject = $request->gcv_adb_reject;
        $lead->gcv_adb_bonus = $request->gcv_adb_bonus;
        $lead->ncv_min = $request->ncv_min;
        $lead->ncv_max = $request->ncv_max;
        $lead->ncv_reject = $request->ncv_reject;
        $lead->ncv_bonus = $request->ncv_bonus;
        $lead->ash_min = $request->ash_min;
        $lead->ash_max = $request->ash_max;
        $lead->ash_reject = $request->ash_reject;
        $lead->ash_bonus = $request->ash_bonus;
        $lead->ts_min = $request->ts_min;
        $lead->ts_max = $request->ts_max;
        $lead->ts_reject = $request->ts_reject;
        $lead->ts_bonus = $request->ts_bonus;
        $lead->tm_min = $request->tm_min;
        $lead->tm_max = $request->tm_max;
        $lead->tm_reject = $request->tm_reject;
        $lead->tm_bonus = $request->tm_bonus;
        $lead->im_min = $request->im_min;
        $lead->im_max = $request->im_max;
        $lead->im_reject = $request->im_reject;
        $lead->im_bonus = $request->im_bonus;
        $lead->fc_min = $request->fc_min;
        $lead->fc_max = $request->fc_max;
        $lead->fc_reject = $request->fc_reject;
        $lead->fc_bonus = $request->fc_bonus;
        $lead->vm_min = $request->vm_min;
        $lead->vm_max = $request->vm_max;
        $lead->vm_reject = $request->vm_reject;
        $lead->vm_bonus = $request->vm_bonus;
        $lead->hgi_min = $request->hgi_min;
        $lead->hgi_max = $request->hgi_max;
        $lead->hgi_reject = $request->hgi_reject;
        $lead->hgi_bonus = $request->hgi_bonus;
        $lead->size_min = $request->size_min;
        $lead->size_max = $request->size_max;
        $lead->size_reject = $request->size_reject;
        $lead->size_bonus = $request->size_bonus;
        $lead->fe2o3_min = $request->fe2o3_min;
        $lead->fe2o3_max = $request->fe2o3_max;
        $lead->fe2o3_reject = $request->fe2o3_reject;
        $lead->fe2o3_bonus = $request->fe2o3_bonus;
        $lead->aft_min = $request->aft_min;
        $lead->aft_max = $request->aft_max;
        $lead->aft_reject = $request->aft_reject;
        $lead->aft_bonus = $request->aft_bonus;

        $lead->volume = $request->volume;
        $lead->price = $request->price;
        $lead->trading_term = $request->trading_term;
        $lead->trading_term_detail = $request->trading_term_detail;
        $lead->payment_terms = $request->payment_terms;
        $lead->commercial_term = $request->commercial_term;
        $lead->penalty_desc = $request->penalty_desc;
        
        $lead->order_status = '1';
        $lead->progress_status = $request->progress_status;
        
        $lead->save();
        
        if ($request->lead_type === 'buy') {
            $seller = Company::find($request->seller_id);
            $lead->seller = $seller;
        }
        else if ($request->lead_type === 'sell') {
            $buyer = Buyer::find($request->buyer_id);
            $lead->buyer = $buyer;
        }

        $lead->order_date = $request->order_date;
        $lead->order_deadline = $request->order_deadline;
        $lead->ready_date = $request->ready_date;
        $lead->expired_date = $request->expired_date;

        return response()->json($lead, 200);

    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id, Request $req){
        
        if ($req->lead_type === 'buy'){
            $lead = Lead::where('lead_type', 'buy')->where('id', $id)->get();
            
            // $subordinates = $this->getSub();
            // foreach ($subordinates as $sub ) {
            //     $all_access[] = $sub->id;
            // }
            // $all_access[] = Auth::User()->id;

            // $sell_order = SellOrder::with('Seller','Port','Concession', 'orders')
            //     ->find($id);

            // if($sell_order->order_status == 'x')
            //     return response()->json(['message'=>'deactivated record'], 404);

            // if(!in_array($sell_order->user_id, $all_access)){
            //     $sell_order->cleanse();
            // }

            return response()->json($lead, 200);
        }
        else if ($req->lead_type === 'sell') {
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
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        $lead = Lead::find($id);
        $lead->user_id = Auth::User()->id;
        $lead->company_id = $request->company_id;

        if ($request->lead_type === 'buy') {
            $lead->lead_type = 'b';
        }
        else if ($request->lead_type === 'sell') {
            $lead->lead_type = 's';
        }

        $lead->order_date = date('Y-m-d',strtotime($request->order_date));
        $lead->order_deadline = date('Y-m-d',strtotime($request->order_deadline));
        $lead->ready_date = date('Y-m-d',strtotime($request->ready_date));
        $lead->expired_date = date('Y-m-d',strtotime($request->expired_date));

        $lead->factory_id = $request->factory_id;
        $lead->address = $request->address;
        $lead->city = $request->city;
        $lead->country = $request->country;
        $lead->latitude = $request->latitude;
        $lead->longitude = $request->longitude;
        $lead->port_distance = $request->port_distance;
        $lead->port_id = $request->port_id;
        $lead->port_name = $request->port_name;
        $lead->port_status = $request->port_status;
        $lead->port_daily_rate = $request->port_daily_rate;
        $lead->port_draft_height = $request->port_draft_height;
        $lead->port_latitude = $request->port_latitude;
        $lead->port_longitude = $request->port_longitude;

        $lead->product_name = $request->product_name;
        $lead->typical_quality = $request->typical_quality;
        $lead->product_id = $request->product_id;

        $lead->gcv_arb_min = $request->gcv_arb_min;
        $lead->gcv_arb_max = $request->gcv_arb_max;
        $lead->gcv_arb_reject = $request->gcv_arb_reject;
        $lead->gcv_arb_bonus = $request->gcv_arb_bonus;
        $lead->gcv_adb_min = $request->gcv_adb_min;
        $lead->gcv_adb_max = $request->gcv_adb_max;
        $lead->gcv_adb_reject = $request->gcv_adb_reject;
        $lead->gcv_adb_bonus = $request->gcv_adb_bonus;
        $lead->ncv_min = $request->ncv_min;
        $lead->ncv_max = $request->ncv_max;
        $lead->ncv_reject = $request->ncv_reject;
        $lead->ncv_bonus = $request->ncv_bonus;
        $lead->ash_min = $request->ash_min;
        $lead->ash_max = $request->ash_max;
        $lead->ash_reject = $request->ash_reject;
        $lead->ash_bonus = $request->ash_bonus;
        $lead->ts_min = $request->ts_min;
        $lead->ts_max = $request->ts_max;
        $lead->ts_reject = $request->ts_reject;
        $lead->ts_bonus = $request->ts_bonus;
        $lead->tm_min = $request->tm_min;
        $lead->tm_max = $request->tm_max;
        $lead->tm_reject = $request->tm_reject;
        $lead->tm_bonus = $request->tm_bonus;
        $lead->im_min = $request->im_min;
        $lead->im_max = $request->im_max;
        $lead->im_reject = $request->im_reject;
        $lead->im_bonus = $request->im_bonus;
        $lead->fc_min = $request->fc_min;
        $lead->fc_max = $request->fc_max;
        $lead->fc_reject = $request->fc_reject;
        $lead->fc_bonus = $request->fc_bonus;
        $lead->vm_min = $request->vm_min;
        $lead->vm_max = $request->vm_max;
        $lead->vm_reject = $request->vm_reject;
        $lead->vm_bonus = $request->vm_bonus;
        $lead->hgi_min = $request->hgi_min;
        $lead->hgi_max = $request->hgi_max;
        $lead->hgi_reject = $request->hgi_reject;
        $lead->hgi_bonus = $request->hgi_bonus;
        $lead->size_min = $request->size_min;
        $lead->size_max = $request->size_max;
        $lead->size_reject = $request->size_reject;
        $lead->size_bonus = $request->size_bonus;
        $lead->fe2o3_min = $request->fe2o3_min;
        $lead->fe2o3_max = $request->fe2o3_max;
        $lead->fe2o3_reject = $request->fe2o3_reject;
        $lead->fe2o3_bonus = $request->fe2o3_bonus;
        $lead->aft_min = $request->aft_min;
        $lead->aft_max = $request->aft_max;
        $lead->aft_reject = $request->aft_reject;
        $lead->aft_bonus = $request->aft_bonus;

        $lead->volume = $request->volume;
        $lead->price = $request->price;
        $lead->trading_term = $request->trading_term;
        $lead->trading_term_detail = $request->trading_term_detail;
        $lead->payment_terms = $request->payment_terms;
        $lead->commercial_term = $request->commercial_term;
        $lead->penalty_desc = $request->penalty_desc;

        $lead->order_status = $request->order_status;
        $lead->progress_status = $request->progress_status;

        $lead->save();

        $lead->order_date = $request->order_date;
        $lead->order_deadline = $request->order_deadline;
        $lead->ready_date = $request->ready_date;
        $lead->expired_date = $request->expired_date;

        return response()->json($lead, 200);
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
