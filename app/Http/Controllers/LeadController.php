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
    public function index(Request $req){
        $subordinates = $this->getSub();
        foreach ($subordinates as $sub ) {
            $all_access[] = $sub->id;
        }
        $all_access[] = Auth::User()->id;

        if ($req->lead_type === 'buy') {
            
            if($req->order&&$req->order_id!==null){
                $user_id = Auth::User()->id;
                $buy_order = BuyOrder::where('id',$req->order_id)->first();
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
                    ->limit($req->limit)
                    ->get();
            }
            else if($req->supplier&&$req->order_id!==null){
                $buy_order = BuyOrder::where('id',$req->order_id)->first();
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
                    ->limit($req->limit)
                    ->get();
            }
            else if($req->order){
                $user_id = Auth::User()->id;
                $sell_order = SellOrder::with('Company','User','trader','used')->where('order_status', 'v')->orwhere('order_status', 'l')->orwhere('order_status', 'p')->get();
            }

            //list lead status
            else if($req->order_status){
                if($req->order_status==='all'){
                    $leads = Lead::with('Company','User','trader','used')
                        ->where([['order_status', '1'], ['user_id', Auth::User()->id],['lead_type', 'b']])
                        ->orwhere([['order_status', '2'], ['user_id', Auth::User()->id],['lead_type', 'b']])
                        ->orwhere([['order_status', '3'], ['user_id', Auth::User()->id],['lead_type', 'b']])
                        ->orwhere([['order_status', '4'], ['user_id', Auth::User()->id],['lead_type', 'b']])
                        ->orwhere([['order_status', 'v'],['lead_type', 'b']])
                        ->orwhere([['order_status', 'l'],['lead_type', 'b']])
                        ->orwhere([['order_status', 's'],['lead_type', 'b']])
                        ->orwhere([['order_status', 'p'],['lead_type', 'b']])
                        ->get();
                } else if($req->order_status==='draft') {
                    $leads = Lead::with('Company','User')
                        ->where([['order_status', '1'], ['user_id', Auth::User()->id],['lead_type', 'b']])
                        ->orwhere([['order_status', '2'], ['user_id', Auth::User()->id],['lead_type', 'b']])
                        ->orwhere([['order_status', '3'], ['user_id', Auth::User()->id],['lead_type', 'b']])
                        ->orwhere([['order_status', '4'], ['user_id', Auth::User()->id],['lead_type', 'b']])
                        ->orwhere([['order_status', '0'], ['user_id', Auth::User()->id],['lead_type', 'b']])
                        ->get();
                } else if ($req->order_status!=='draft') {
                    $leads = Lead::with('Company','User','Product','used')
                    ->where('order_status', $req->order_status)
                    ->where('lead_type', 'b')
                    ->get();
                }

                foreach ($leads as $lead) {
                    if ($lead->order_status!=='s') {
                        if(!in_array($lead->user_id, $all_access)){
                            $lead->cleanse();
                        }
                    }
                }
            }
            
            return response()->json($leads, 200);

        }
        else if ($req->lead_type === 'sell') {

            if($req->order&&$req->order_id!==null){
                $user_id = Auth::User()->id;
                $sell_order = SellOrder::where('id',$req->order_id)->first();
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
                    ->limit($req->limit)
                    ->get();
            }
            else if($req->customer&&$req->order_id!==null){
                $sell_order = SellOrder::where('id',$req->order_id)->first();
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
                    ->limit($req->limit)
                    ->get();
            }
            else if(!$req->order){
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
            else if($req->order){
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
  * @param  \Illuminate\Http\Request  $req
  * @return \Illuminate\Http\Response
  */
    public function store(Request $req){
        if(!$req) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        $lead = new Lead();
        $lead->user_id = Auth::User()->id;
        $lead->company_id = $req->company_id;

        if ($req->lead_type === 'buy') {
            $lead->lead_type = 'b';
        }
        else if ($req->lead_type === 'sell') {
            $lead->lead_type = 's';
        }
        $lead->order_date = date('Y-m-d',strtotime($req->order_date));
        $lead->order_deadline = date('Y-m-d',strtotime($req->order_deadline));
        $lead->ready_date = date('Y-m-d',strtotime($req->ready_date));
        $lead->expired_date = date('Y-m-d',strtotime($req->expired_date));

        $lead->address = $req->address;
        $lead->city = $req->city;
        $lead->country = $req->country;
        $lead->latitude = $req->latitude;
        $lead->longitude = $req->longitude;
        $lead->port_distance = $req->port_distance;
        $lead->port_id = $req->port_id;
        $lead->port_name = $req->port_name;
        $lead->port_status = $req->port_status;
        $lead->port_daily_rate = $req->port_daily_rate;
        $lead->port_draft_height = $req->port_draft_height;
        $lead->port_latitude = $req->port_latitude;
        $lead->port_longitude = $req->port_longitude;

        $lead->product_name = $req->product_name;
        $lead->typical_quality = $req->typical_quality;
        $lead->product_id = $req->product_id;

        $lead->gcv_arb_min = $req->gcv_arb_min;
        $lead->gcv_arb_max = $req->gcv_arb_max;
        $lead->gcv_arb_reject = $req->gcv_arb_reject;
        $lead->gcv_arb_bonus = $req->gcv_arb_bonus;
        $lead->gcv_adb_min = $req->gcv_adb_min;
        $lead->gcv_adb_max = $req->gcv_adb_max;
        $lead->gcv_adb_reject = $req->gcv_adb_reject;
        $lead->gcv_adb_bonus = $req->gcv_adb_bonus;
        $lead->ncv_min = $req->ncv_min;
        $lead->ncv_max = $req->ncv_max;
        $lead->ncv_reject = $req->ncv_reject;
        $lead->ncv_bonus = $req->ncv_bonus;
        $lead->ash_min = $req->ash_min;
        $lead->ash_max = $req->ash_max;
        $lead->ash_reject = $req->ash_reject;
        $lead->ash_bonus = $req->ash_bonus;
        $lead->ts_min = $req->ts_min;
        $lead->ts_max = $req->ts_max;
        $lead->ts_reject = $req->ts_reject;
        $lead->ts_bonus = $req->ts_bonus;
        $lead->tm_min = $req->tm_min;
        $lead->tm_max = $req->tm_max;
        $lead->tm_reject = $req->tm_reject;
        $lead->tm_bonus = $req->tm_bonus;
        $lead->im_min = $req->im_min;
        $lead->im_max = $req->im_max;
        $lead->im_reject = $req->im_reject;
        $lead->im_bonus = $req->im_bonus;
        $lead->fc_min = $req->fc_min;
        $lead->fc_max = $req->fc_max;
        $lead->fc_reject = $req->fc_reject;
        $lead->fc_bonus = $req->fc_bonus;
        $lead->vm_min = $req->vm_min;
        $lead->vm_max = $req->vm_max;
        $lead->vm_reject = $req->vm_reject;
        $lead->vm_bonus = $req->vm_bonus;
        $lead->hgi_min = $req->hgi_min;
        $lead->hgi_max = $req->hgi_max;
        $lead->hgi_reject = $req->hgi_reject;
        $lead->hgi_bonus = $req->hgi_bonus;
        $lead->size_min = $req->size_min;
        $lead->size_max = $req->size_max;
        $lead->size_reject = $req->size_reject;
        $lead->size_bonus = $req->size_bonus;
        $lead->fe2o3_min = $req->fe2o3_min;
        $lead->fe2o3_max = $req->fe2o3_max;
        $lead->fe2o3_reject = $req->fe2o3_reject;
        $lead->fe2o3_bonus = $req->fe2o3_bonus;
        $lead->aft_min = $req->aft_min;
        $lead->aft_max = $req->aft_max;
        $lead->aft_reject = $req->aft_reject;
        $lead->aft_bonus = $req->aft_bonus;

        $lead->volume = $req->volume;
        $lead->price = $req->price;
        $lead->trading_term = $req->trading_term;
        $lead->trading_term_detail = $req->trading_term_detail;
        $lead->payment_terms = $req->payment_terms;
        $lead->commercial_term = $req->commercial_term;
        $lead->penalty_desc = $req->penalty_desc;
        
        $lead->order_status = '1';
        $lead->progress_status = $req->progress_status;
        
        $lead->save();
        
        if ($req->lead_type === 'buy') {
            $seller = Company::find($req->seller_id);
            $lead->seller = $seller;
        }
        else if ($req->lead_type === 'sell') {
            $buyer = Buyer::find($req->buyer_id);
            $lead->buyer = $buyer;
        }

        $lead->order_date = $req->order_date;
        $lead->order_deadline = $req->order_deadline;
        $lead->ready_date = $req->ready_date;
        $lead->expired_date = $req->expired_date;

        return response()->json($lead, 200);

    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id, Request $req){
        
        $lead = Lead::with('Company','Port','Concession', 'orders');
        if ($req->lead_type === 'buy'){
            $lead->where('lead_type', 'b');
        }
        else if ($req->lead_type === 'sell') {
            $lead->where('lead_type', 's');
        }

        $lead = $lead->where('id', $id)->first();
            
        $subordinates = $this->getSub();
        foreach ($subordinates as $sub ) {
            $all_access[] = $sub->id;
        }
        $all_access[] = Auth::User()->id;

        if(!$lead) return response()->json(['message' => 'Bad Request'], 404);

        if($lead->order_status == 'x')
            return response()->json(['message'=>'deactivated record'], 404);

        if(!in_array($lead->user_id, $all_access)){
            $lead->cleanse();
        }

        return response()->json($lead, 200);
    }

    public function update(Request $req, $id){
        if (!$req) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        $lead = Lead::find($id);
        $lead->user_id = Auth::User()->id;
        $lead->company_id = $req->company_id;

        if ($req->lead_type === 'buy') {
            $lead->lead_type = 'b';
        }
        else if ($req->lead_type === 'sell') {
            $lead->lead_type = 's';
        }

        $lead->order_date = date('Y-m-d',strtotime($req->order_date));
        $lead->order_deadline = date('Y-m-d',strtotime($req->order_deadline));
        $lead->ready_date = date('Y-m-d',strtotime($req->ready_date));
        $lead->expired_date = date('Y-m-d',strtotime($req->expired_date));

        $lead->factory_id = $req->factory_id;
        $lead->address = $req->address;
        $lead->city = $req->city;
        $lead->country = $req->country;
        $lead->latitude = $req->latitude;
        $lead->longitude = $req->longitude;
        $lead->port_distance = $req->port_distance;
        $lead->port_id = $req->port_id;
        $lead->port_name = $req->port_name;
        $lead->port_status = $req->port_status;
        $lead->port_daily_rate = $req->port_daily_rate;
        $lead->port_draft_height = $req->port_draft_height;
        $lead->port_latitude = $req->port_latitude;
        $lead->port_longitude = $req->port_longitude;

        $lead->product_name = $req->product_name;
        $lead->typical_quality = $req->typical_quality;
        $lead->product_id = $req->product_id;

        $lead->gcv_arb_min = $req->gcv_arb_min;
        $lead->gcv_arb_max = $req->gcv_arb_max;
        $lead->gcv_arb_reject = $req->gcv_arb_reject;
        $lead->gcv_arb_bonus = $req->gcv_arb_bonus;
        $lead->gcv_adb_min = $req->gcv_adb_min;
        $lead->gcv_adb_max = $req->gcv_adb_max;
        $lead->gcv_adb_reject = $req->gcv_adb_reject;
        $lead->gcv_adb_bonus = $req->gcv_adb_bonus;
        $lead->ncv_min = $req->ncv_min;
        $lead->ncv_max = $req->ncv_max;
        $lead->ncv_reject = $req->ncv_reject;
        $lead->ncv_bonus = $req->ncv_bonus;
        $lead->ash_min = $req->ash_min;
        $lead->ash_max = $req->ash_max;
        $lead->ash_reject = $req->ash_reject;
        $lead->ash_bonus = $req->ash_bonus;
        $lead->ts_min = $req->ts_min;
        $lead->ts_max = $req->ts_max;
        $lead->ts_reject = $req->ts_reject;
        $lead->ts_bonus = $req->ts_bonus;
        $lead->tm_min = $req->tm_min;
        $lead->tm_max = $req->tm_max;
        $lead->tm_reject = $req->tm_reject;
        $lead->tm_bonus = $req->tm_bonus;
        $lead->im_min = $req->im_min;
        $lead->im_max = $req->im_max;
        $lead->im_reject = $req->im_reject;
        $lead->im_bonus = $req->im_bonus;
        $lead->fc_min = $req->fc_min;
        $lead->fc_max = $req->fc_max;
        $lead->fc_reject = $req->fc_reject;
        $lead->fc_bonus = $req->fc_bonus;
        $lead->vm_min = $req->vm_min;
        $lead->vm_max = $req->vm_max;
        $lead->vm_reject = $req->vm_reject;
        $lead->vm_bonus = $req->vm_bonus;
        $lead->hgi_min = $req->hgi_min;
        $lead->hgi_max = $req->hgi_max;
        $lead->hgi_reject = $req->hgi_reject;
        $lead->hgi_bonus = $req->hgi_bonus;
        $lead->size_min = $req->size_min;
        $lead->size_max = $req->size_max;
        $lead->size_reject = $req->size_reject;
        $lead->size_bonus = $req->size_bonus;
        $lead->fe2o3_min = $req->fe2o3_min;
        $lead->fe2o3_max = $req->fe2o3_max;
        $lead->fe2o3_reject = $req->fe2o3_reject;
        $lead->fe2o3_bonus = $req->fe2o3_bonus;
        $lead->aft_min = $req->aft_min;
        $lead->aft_max = $req->aft_max;
        $lead->aft_reject = $req->aft_reject;
        $lead->aft_bonus = $req->aft_bonus;

        $lead->volume = $req->volume;
        $lead->price = $req->price;
        $lead->trading_term = $req->trading_term;
        $lead->trading_term_detail = $req->trading_term_detail;
        $lead->payment_terms = $req->payment_terms;
        $lead->commercial_term = $req->commercial_term;
        $lead->penalty_desc = $req->penalty_desc;

        $lead->order_status = $req->order_status;
        $lead->progress_status = $req->progress_status;

        $lead->save();

        $lead->order_date = $req->order_date;
        $lead->order_deadline = $req->order_deadline;
        $lead->ready_date = $req->ready_date;
        $lead->expired_date = $req->expired_date;

        return response()->json($lead, 200);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($buyer){
        if ($req->type === 'buy'){
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
        else if ($req->type === 'sell'){
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
