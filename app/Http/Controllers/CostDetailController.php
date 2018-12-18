<?php

namespace App\Http\Controllers;

use App\Model\CostDetail;
use App\Model\CostHeader;

use Illuminate\Http\Request;
use Auth;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class CostDetailController extends Controller
{
  public function __construct() {
    $this->middleware('jwt.auth');
  }
  
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $req)
  {
    //return($req->cost_header);
    $cost_details = CostDetail::with('costSection','costHeader.calculationType','costHeader.miningLicense','user');
    if($req->sum) 
      $cost_details->select('header_id','section_id', DB::raw('SUM(base_value) as total_base_value'), DB::raw('SUM(deal_value) as total_deal_value'))
      ->groupBy('header_id','section_id');    
    $cost_details->where('status','a');

    if($req->costHeader_id){      
      $cost_details->whereHas('costHeader', function($query) use ($req){
        $query->where('header_id','=',$req->costHeader_id);
      });
    }
    if($req->section_id){
      $cost_details->where('section_id','=',$req->section_id);
    }    

    if($req->mining_license_id&&$req->calculation_id){
      $cost_details->whereHas('costHeader', function($q) use ($req) { 
        $q->whereRaw('mining_license_id = '.$req->mining_license_id);
        $q->whereRaw('calculation_id = '.$req->calculation_id);
      });     
    }

    return response()->json($cost_details->get(), 200);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $cost_detail = CostDetail::find($id);

    if($cost_detail->status != 'a')
      return response()->json(['message' => 'deactivated record'], 404);
    
    return response()->json($cost_detail, 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $req
   * @return \Illuminate\Http\Response
   */
  public function store(Request $req)
  {
    if(!$req) {
      return response()->json([
        'message' => 'Bad Request'
      ], 400);
    }

    $cost_header = CostHeader::where('calculation_id',$req->calculation_id)->where('mining_license_id',$req->mining_license_id)->first();    
    if(!$cost_header){
      $cost_header = new CostHeader();
      $cost_header->calculation_id = $req->calculation_id;
      $cost_header->mining_license_id = $req->mining_license_id;
      $cost_header->save();
    }

    if($req->cogs){
      for ($i=0; $i < count($req->cogs); $i++) { 
        if(!empty($req->cogs[$i]['base_value'])){
          $cost_detail = CostDetail::where('section_id',$req->section_id)->where('header_id',$cost_header->id)
          ->where('desc',$req->cogs[$i]['desc'])->where('status','a')->first();
          $newvalue = false;
          if($cost_detail){
            if($cost_detail->base_value != $req->cogs[$i]['base_value']){
              $newvalue = true;
              $cost_detail->status = 'x';
              $cost_detail->save();
            }
          }
          if($newvalue||!$cost_detail){
            $cost_detail = new CostDetail();
            $cost_detail->section_id = $req->section_id;
            $cost_detail->header_id = $cost_header->id;
            $cost_detail->user_id = Auth::User()->id;
            $cost_detail->desc = $req->cogs[$i]['desc'];
            $cost_detail->base_value = $req->cogs[$i]['base_value'];
            $cost_detail->deal_value = $req->cogs[$i]['deal_value'];
            $cost_detail->quantity = $req->quantity ? $req->quantity : 1;
            $cost_detail->status = 'a';
            $cost_detail->save();
          }
        }
      }      
    }
    // return response()->json($req->investment);
    if($req->investment){      
      for ($i=0; $i < count($req->investment) ; $i++) { 
        $cost_detail = CostDetail::where('section_id',$req->section_id)->where('header_id',$cost_header->id)
          ->where('desc',$req->investment[$i]['desc'])->where('status','a')->first();
        $newvalue = false;
        if($cost_detail){
          if($cost_detail->base_value != $req->investment[$i]['base_value'] || $cost_detail->quantity != $req->investment[$i]['quantity']){
            $newvalue = true;
            $cost_detail->status = 'x';
            $cost_detail->save();
          }
        }
        
        if($newvalue||!$cost_detail){
          $cost_detail = new CostDetail();
          $cost_detail->section_id = $req->section_id;
          $cost_detail->header_id = $cost_header->id;
          $cost_detail->user_id = Auth::User()->id;
          $cost_detail->desc = $req->investment[$i]['desc'];
          $cost_detail->base_value = $req->investment[$i]['base_value'];
          $cost_detail->deal_value = $req->investment[$i]['deal_value'];
          $cost_detail->quantity = $req->investment[$i]['quantity'];
          $cost_detail->status = 'a';
          $cost_detail->save();
        }
      }
    }

    
    if(empty($cost_detail)) $cost_detail = true;

    return response()->json($cost_detail, 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $req
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $req, $id)
  {
    if($req->detail){
      //$details = DB::table('cost_details')->where('header_id', $id)->where('section_id', $req->section_id)->get();
      // return response()->json($req);
      $details = CostDetail::where('header_id', $id)->where('section_id', $req->section_id)->get();
            
      foreach($details as $key => $d){        
          # code...
        $d->base_value = $req->detail[$key]['base_value'];
        $d->deal_value = $req->detail[$key]['deal_value'];
        $d->quantity = $req->detail[$key]['quantity'];        
        $d->save();
      }
    }
    if (!$req) return response()->json([ 'message' => 'Bad Request' ], 400);

    // $cost_details = CostDetail::find($id);

    // if (!$cost_details) return response()->json([ 'message' => 'Not found' ] ,404);

    // $cost_detail->section_id = $req->section_id;
    // $cost_detail->header_id = $req->header_id;
    // $cost_detail->user_id = $req->user_id;
    // $cost_detail->desc = $req->desc;
    // $cost_detail->value = $req->value;
    // $cost_detail->quantity = $req->quantity ? $req->quantity : 1;
    // $cost_detail->status = 'a';

    return response()->json([ 'message' => 'Update Successfully' ], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $cost_detail = CostDetail::where('status', 'a')->find($id);
    
    if (!$cost_detail) return response()->json([ 'message' => 'Not found or Deactivated Record' ] ,404);

    $cost_detail->status = 'a';
    $cost_detail->save();

    return response()->json($cost_detail, 200);
  }
}
