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
  public function index(){
    $indices = Index::get();
    return response()->json($indices, 200);
  }

  public function price(Request $request){
  	$indices = $request->indexId;
  	$date_start = $request->date_start;
  	$date_end = $request->date_end;
  	$frequency = $request->frequency;

  	$indices = Index::whereIn('id', $indices)->get();

  	$column = 'MAX(date) "date"';

  	foreach($indices as $index){
	  	$column .= ', AVG(CASE WHEN index_id = ' . $index->id . ' THEN price END) "' . $index->id . '"';
  	}

  	$query = DB::table('index_price')
  		->select(DB::raw($column))
  		->orderBy('date', 'DESC');

    if($date_start) $query->where('date', '>=', $date_start);
    if($date_end) $query->where('date', '<=', $date_end);

    switch($frequency){
    	case 'daily' : $query->groupBy('day_of_year', 'year'); break;
    	case 'weekly' : $query->groupBy('week', 'year'); break;
    	case 'monthly' : $query->groupBy('month', 'year'); break;
    }

    return response()->json([ 'indices' => $indices, 'prices' => $query->get() ], 200);
  }
}
