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
    
    switch($frequency){
      case 'daily' : $column = 'MAX(DATE_FORMAT(date,"%d %M %Y")) "date", MAX(date) as real_date'; break;
    	case 'weekly' : $column = 'CONCAT("Week ", MAX(DATE_FORMAT(date,"%V - %M %Y"))) "date", MAX(date) as real_date'; break;
    	case 'monthly' : $column = 'MAX(DATE_FORMAT(date,"%M %Y")) "date", MAX(date) as real_date'; break;
    }

  	foreach($indices as $index){
	  	$column .= ', AVG(CASE WHEN index_id = ' . $index->id . ' THEN price END) "' . $index->id . '"';
  	}

  	$query = DB::table('index_price')
  		->select(DB::raw($column))
  		->orderBy('real_date', 'DESC');

    if($date_start) $query->where('date', '>=', $date_start);
    if($date_end) $query->where('date', '<=', $date_end);

    switch($frequency){
    	case 'daily' : $query->groupBy('day_of_year', 'year'); break;
    	case 'weekly' : $query->groupBy('week', 'year'); break;
    	case 'monthly' : $query->groupBy('month', 'year'); break;
    }

    return response()->json([ 'indices' => $indices, 'prices' => $query->get() ], 200);
  }

  public function singlePrice(Request $request){
  	$index = $request->indexId;
  	$date_start = $request->date_start;
  	$date_end = $request->date_end;
  	$frequency = $request->frequency;
    
    $year_start = date('Y', strtotime($date_start));
    $year_end = date('Y', strtotime($date_end));
    
    $month_start = date('m', strtotime($date_start));
    $month_end = date('m', strtotime($date_end));

    for($x=$year_start; $x<=$year_end; $x++){
	  	$query = DB::table('index_price')
	  		->select(DB::raw('MAX(date) "date", AVG(price) "price"'))
	  		->where('index_id', $index)
	  		->orderBy('date', 'DESC');

	    if($date_start) $query->where('date', '>=', $x.'-'.$month_start.'-01');
	    if($date_end) $query->where('date', '<=', ($x+1).'-'.$month_end.'-28');

	    switch($frequency){
	    	case 'daily' : $query->groupBy('day_of_year', 'year'); break;
	    	case 'weekly' : $query->groupBy('week', 'year'); break;
	    	case 'monthly' : $query->groupBy('month', 'year'); break;
	    }

	    $result[date('Y', strtotime($date_start))] = $query->get();
      
      /*echo $date_start.'\n';
      echo $date_end.'\n';
      echo $query->toSql().'\n';

	  	$date_start = date('Y-m-d', strtotime($date_start . ' +1 year'));
	  	$date_end = date('Y-m-d', strtotime($date_end . ' +1 year'));*/
    }

    return response()->json($result , 200);
  }
}
