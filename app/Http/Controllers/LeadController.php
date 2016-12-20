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
   * Requests $req components
   * lead_type --> the type of the leads itself buy or sell
   * order_status --> the status of the leads in corporate order point of view
   * 
   */
  public function index(Request $req){
    // get all subordinate of current users
    $subs = Auth::user()->subordinates();
    $users = $subs->pluck('id')->all(); 
    $users[] = Auth::User()->id;

    // this is the basic loading query of all leads
    $query = Lead::with('Company','User','trader','used', 'Product');

    // lowercasing lead_type
    $lead_type = strtolower($req->lead_type);

    // choose lead type, for view lead recomend using right condition 
    if ($lead_type === 'buy' || $req->lead_type === 's') $query->where('lead_type', 'b');
    else if ($lead_type === 'sell' || $req->lead_type === 'b') $query->where('lead_type', 's');

    // select statuses to include based on query category
    if($req->order) $status = ['v', 'l', 'p']; // only v, l, p IF this is a lead added to orders
    else if($req->order_status==='all') $status = ['v', 'l', 's', 'p'];
    else if($req->order_status==='draft') { $status = ['0', '1', '2', '3', '4']; $user_id = true; }
    else if($req->order_status!==null) $query->where('order_status', $req->order_status);

    if (isset($status)) $query->whereIn('order_status', $status);
    if (isset($user_id)) $query->where('user_id', Auth::User()->id);

    // company_type based on lead type of the reference lead
    if($req->lead_id){
      $ref = Lead::where('id',$req->lead_id)->first();

      // in case searching for product, replace the query
      $company_type = $ref->lead_type === 'b' ? 'c' : 's';
      if($req->matching === 'products'){
        $query = Product::with('Company')
          ->limit($req->limit);
      }
    }

    $leads = $query->limit($req->limit)->get();

    //list recomended leads from compare leads to a lead
    if($req->lead_id && ($req->order === 'matching' || $req->matching === 'leads')) 
      foreach ($leads as $lead) {
        $lead->difference($ref);
      }

    //list recomended product from compare product to a lead
    else if($req->lead_id && $req->matching === 'products')
      foreach ($leads as $lead) {
        $lead->difference($ref, $company_type);
      }

    //list lead status at buy / sell lead
    else
      foreach ($leads as $lead) {
        if ($lead->order_status!=='s') {
          if(!in_array($lead->user_id, $users)){
            $lead->cleanse();
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

    $lead = new Lead($req->all());

    $lead->user_id = Auth::User()->id;
    $lead->company_id = $req->company_id;

    if ($req->lead_type === 'buy') {
      $lead->lead_type = 'b';
    }
    else if ($req->lead_type === 'sell') {
      $lead->lead_type = 's';
    }

    $lead->order_date = date('Y-m-d',strtotime($req->order_date));
    $lead->order_expired = date('Y-m-d',strtotime($req->order_expired));
    $lead->laycan_start = date('Y-m-d',strtotime($req->laycan_start));
    $lead->laycan_end = date('Y-m-d',strtotime($req->laycan_end));
    
    $lead->order_status = '1';
    
    $lead->save();
    
    if ($req->lead_type === 'buy') {
      $seller = Company::find($req->seller_id);
      $lead->seller = $seller;
    }
    else if ($req->lead_type === 'sell') {
      $buyer = Company::find($req->buyer_id);
      $lead->buyer = $buyer;
    }

    $lead->order_date = $req->order_date;
    $lead->order_expired = $req->order_expired;
    $lead->laycan_start = $req->laycan_start;
    $lead->laycan_end = $req->laycan_end;

    return response()->json($lead, 200);

  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show(Request $req, $id){
    
    $lead = Lead::with('company','port','concession','product','used','orders');
    if ($req->lead_type === 'buy'){
      $lead->where('lead_type', 'b');
    }
    else if ($req->lead_type === 'sell') {
      $lead->where('lead_type', 's');
    }

    $lead = $lead->where('id', $id)->first();
      
    $subs = Auth::user()->subordinates();
    $all_access = $subs->pluck('id')->all(); 
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
    $lead->fill($req->all());

    // you can only change company_id if this is a draft
    if(is_numeric($lead->order_status)){
      $lead->company_id = $req->company_id;
    }

    $lead->order_date = date('Y-m-d',strtotime($req->order_date));
    $lead->order_expired = date('Y-m-d',strtotime($req->order_expired));
    $lead->laycan_start = date('Y-m-d',strtotime($req->laycan_start));
    $lead->laycan_end = date('Y-m-d',strtotime($req->laycan_end));

    $lead->order_status = $req->order_status;

    $lead->save();

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

}
