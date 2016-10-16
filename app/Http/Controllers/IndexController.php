<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Model\Index;
use App\Model\IndexPrice;

use App\Http\Requests;


class IndexController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $indices = Index::get();
    return response()->json($indices, 200);
  }

  public function price(Request $request)
  {
  	// $indices = $request->indexId;
  	// $date_start = $request->date_start;
  	// $date_end = $request->date_end;
  	// $frequency = $request->frequency;

  	$query = DB::table('concession')
      //->select('concession.id', 'concession.latitude')
      ->select(['concession.id', 'concession.latitude', 'concession.longitude', 'concession.polygon'])
      /*->join('products', 'products.concession_id', '=', 'concession.id')
      ->where('concession.status', 'a')
      ->where('products.status', 'a')*/;
    
    $concession = $query->get();

    return response()->json($concession, 200);




  //   SELECT  DATE_FORMAT(PunchDateTime, '%W') DAY,
		//         MAX(CASE WHEN PunchEvent = 'ClockIn' THEN DATE_FORMAT(PunchDateTime, '%r') END) ClockIn,
		//         MAX(CASE WHEN PunchEvent = 'BreakOut' THEN DATE_FORMAT(PunchDateTime, '%r') END) BreakOut,
		//         MAX(CASE WHEN PunchEvent = 'BreakIn' THEN DATE_FORMAT(PunchDateTime, '%r') END) BreakIn,
		//         MAX(CASE WHEN PunchEvent = 'ClockOut' THEN DATE_FORMAT(PunchDateTime, '%r') END) ClockOut
		// FROM    tableName
		// WHERE   EmpID = 456
		// GROUP   BY DATE_FORMAT(PunchDateTime, '%W')
		// ORDER   BY PunchDateTime


    // $indexPrices = IndexPrice::select('date', 'price')->where('index_id', $id);

    // if($request->date_start) $indexPrices->where('date', '>=', $request->date_start);
    // if($request->date_end) $indexPrices->where('date', '<=', $request->date_end);

    // $indexPrices = $indexPrices->get();
    // return response()->json($indexPrices, 200);
  }
}
