<?php

namespace App\Http\Controllers;

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
        // get all subordinate of current users
        $subs = Auth::user()->subordinates();
        $subs_id = $subs->pluck('id')->all();

        // this is the basic loading query of all leads
        $query = Lead::with('trader', 'users');

        // choose lead type
        if ($req->lead_type === 'buy') $query->where('lead_type', 'b');
        else if ($req->lead_type === 'sell') $query->where('lead_type', 's');

        // select statuses to include based on query category
        //if($req->order_status==='all') $status = ['0', '1', '2', '3', '4', 'v', 'l', 's', 'p'];
        if($req->order_status==='draft') $status = ['0', '1', '2', '3', '4'];
        else $status = ['v', 'p'];

        $query->whereIn('order_status', $status);



        return $subs_id;


        foreach ($subordinates as $sub ) {
            $all_access[] = $sub->id;
        }
        $all_access[] = Auth::User()->id;

        if ($req->lead_type === 'buy') $lead_type = 'b';
        else if ($req->lead_type === 'sell') $lead_type = 's';

        if ($lead_type == 'b') $compare_type = 's';
        else if ($lead_type == 's') $compare_type = 'b';

        if ($company_type == 's') $compare_type = 'b';
        else if ($company_type == 'c') $compare_type = 's';

        $compare = Lead::where('id',$req->lead_id)->where('lead_type', $compare_type)->first();

        if($req->order&&$req->lead_id!==null){
            $leads = Lead::where('lead_type', $lead_type)->limit($req->limit)->get();
            foreach ($leads as $lead) {
                $lead->difference($compare);
            }
        }
        else if($req->company&&$req->lead_id!==null){
            $leads = Product::with('Company')
                ->limit($req->limit)
                ->get();
            foreach ($leads as $lead) {
                $lead->difference($compare, $company_type);
            }
        }
        


        if ($req->lead_type === 'buy') {
            
            if($req->order&&$req->lead_id!==null){
                $compare = Lead::where('id',$req->lead_id)->where('lead_type', 'b')->first();
                $leads = Lead::where('lead_type', 's')->limit($req->limit)->get();
                foreach ($leads as $lead) {
                    $lead->difference($compare);
                }
            }
            else if($req->supplier&&$req->lead_id!==null){
                $compare = Lead::where('id',$req->lead_id)->where('lead_type', 'b')->first();
                $leads = Product::with('Company')
                    ->limit($req->limit)
                    ->get();
                foreach ($leads as $lead) {
                    $lead->difference($compare,'s');
                }
            }
            else if($req->order){
                $leads = Lead::with('Company','User','trader','used')
                    ->where([['order_status', 'v'],['lead_type', 'b']])
                    ->orwhere([['order_status', 'l'],['lead_type', 'b']])
                    ->orwhere([['order_status', 'p'],['lead_type', 'b']])
                    ->get();
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
        }
        else if ($req->lead_type === 'sell') {

            if($req->order&&$req->lead_id!==null){
                $compare = Lead::where('id',$req->lead_id)->where('lead_type', 's')->first();
                $leads = Lead::where('lead_type', 'b')->limit($req->limit)->get();
                foreach ($leads as $lead) {
                    $lead->difference($compare);
                }
            }
            else if($req->customer&&$req->lead_id!==null){
                $compare = Lead::where('id',$req->lead_id)->where('lead_type', 's')->first();
                $leads = Product::with('Company')
                    ->limit($req->limit)
                    ->get();
                foreach ($leads as $lead) {
                    $lead->difference($compare,'b');
                }
            }
            else if($req->order){
               $leads = Lead::with('Company','User','trader','used')
                    ->where([['order_status', 'v'],['lead_type', 's']])
                    ->orwhere([['order_status', 'l'],['lead_type', 's']])
                    ->orwhere([['order_status', 'p'],['lead_type', 's']])
                    ->get();
            }

            //list lead status
            else if($req->order_status){
                if($req->order_status==='all'){
                    $leads = Lead::with('Company','User','trader','used')
                        ->where([['order_status', '1'], ['user_id', Auth::User()->id],['lead_type', 's']])
                        ->orwhere([['order_status', '2'], ['user_id', Auth::User()->id],['lead_type', 's']])
                        ->orwhere([['order_status', '3'], ['user_id', Auth::User()->id],['lead_type', 's']])
                        ->orwhere([['order_status', '4'], ['user_id', Auth::User()->id],['lead_type', 's']])
                        ->orwhere([['order_status', 'v'],['lead_type', 's']])
                        ->orwhere([['order_status', 'l'],['lead_type', 's']])
                        ->orwhere([['order_status', 's'],['lead_type', 's']])
                        ->orwhere([['order_status', 'p'],['lead_type', 's']])
                        ->get();
                } else if($req->order_status==='draft') {
                    $leads = Lead::with('Company','User')
                        ->where([['order_status', '1'], ['user_id', Auth::User()->id],['lead_type', 's']])
                        ->orwhere([['order_status', '2'], ['user_id', Auth::User()->id],['lead_type', 's']])
                        ->orwhere([['order_status', '3'], ['user_id', Auth::User()->id],['lead_type', 's']])
                        ->orwhere([['order_status', '4'], ['user_id', Auth::User()->id],['lead_type', 's']])
                        ->orwhere([['order_status', '0'], ['user_id', Auth::User()->id],['lead_type', 's']])
                        ->get();
                } else if ($req->order_status!=='draft') {
                    $leads = Lead::with('Company','User','Product','used')
                    ->where('order_status', $req->order_status)
                    ->where('lead_type', 's')
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
        }

        return response()->json($leads, 200);
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
    public function destroy($id){
        $lead = Lead::find($id);

        if (!$lead) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $lead->order_status = 'x';
        $lead->save();

        return response()->json($lead, 200);
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
