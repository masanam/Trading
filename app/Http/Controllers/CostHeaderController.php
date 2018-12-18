<?php

namespace App\Http\Controllers;

use App\Model\CostHeader;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class CostHeaderController extends Controller
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
    $cost_headers = CostHeader::with('calculationType', 'costDetailSum', 'costTotal', 'miningLicense','MiningLicense.company','MiningLicense.contact', 'MiningLicense.checked_by');    
    if($req->type=='investment-cost'){
      $cost_headers = $cost_headers->where('calculation_id','=',1);  
      $calculation_id = 1;    
    }
    if($req->type=='cogs'){
      $cost_headers = $cost_headers->where('calculation_id','=',2);
      $calculation_id = 2;
    }
    if($req->mining_license_id) $cost_headers->where('mining_license_id',$req->mining_license_id);

    if($req->type&&$req->mining_license_id){
      $cost_headers = $cost_headers->first();
      if(!$cost_headers){
        if($req->base === 'USD') $deal = 'IDR';
        else $deal = 'USD';
        $cost_headers = new CostHeader();
        $cost_headers->calculation_id = $calculation_id;
        $cost_headers->mining_license_id = $req->mining_license_id;
        $cost_headers->base_currency_id = $req->base;
        $cost_headers->deal_currency_id = $deal;
        $cost_headers->exchange_rate = $req->exchange_rate;
        $cost_headers->save();
      }
    }
    else $cost_headers = $cost_headers->get();

    return response()->json($cost_headers, 200);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $cost_detail = CostHeader::find($id);

    // if($cost_detail->status != 'a')
    //   return response()->json(['message' => 'deactivated record'], 404);
    
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

    $cost_header = new CostHeader();
    $cost_header->calculation_id = $req->calculation_id;
    $cost_header->mining_license_id = $req->mining_license_id;
    $cost_header->date_of_analysis = $req->date_of_analysis;
    $cost_header->profit_sharing = $req->profit_sharing;
    $cost_header->base_currency_id = $req->base_currency_id;
    $cost_header->deal_currency_id = $req->deal_currency_id;
    $cost_header->exchange_rate = $req->exchange_rate;
    $cost_header->save();

    return response()->json($cost_header, 200);
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
    $cost_header = CostHeader::find($id);

    $cost_header->calculation_id = $req->calculation_id;
    $cost_header->mining_license_id = $req->mining_license_id;
    $cost_header->date_of_analysis = $req->date_of_analysis;
    $cost_header->profit_sharing = $req->profit_sharing;
    $cost_header->base_currency_id = $req->base_currency_id;
    $cost_header->deal_currency_id = $req->deal_currency_id;
    $cost_header->exchange_rate = $req->exchange_rate;
    $cost_header->save();

    return response()->json($cost_header, 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $cost_detail = CostHeader::where('status', 'a')->find($id);
    
    if (!$cost_detail) return response()->json([ 'message' => 'Not found or Deactivated Record' ] ,404);

    $cost_detail->status = 'a';
    $cost_detail->save();

    return response()->json($cost_detail, 200);
  }
}
