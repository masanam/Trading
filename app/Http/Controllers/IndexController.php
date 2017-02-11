<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Model\Index;
use App\Model\IndexPrice;

use App\Http\Requests;
use Auth;

class IndexController extends Controller
{
  // public function __construct(Index $index) {
  //   $this->middleware('jwt.auth');
  //   $this->index = $index;
  // }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(){
    $indices = Index::get();

    return response()->json($indices, 200);
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

    $index = new Index();
    $this->authorize('create', $index);
    
    $index->index_provider = $req->index_provider;
    $index->index_name = $req->index_name;
    $index->quality = $req->quality;
    $index->frequency = substr($req->frequency, 0, 1);

    $index->created_at = Date('Y-m-d H:i:s');
    $index->updated_at = Date('Y-m-d H:i:s');
    $index->save();

    return response()->json($index, 200);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $index = Index::find($id);
    if(!$index) return response()->json([ 'message' => 'Not Found' ], 404);
    return response()->json($index, 200);
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
    $index = Index::find($id);
    $this->authorize('update', $index);

    if (!$req) {
      return response()->json([
        'message' => 'Bad Request'
      ], 400);
    }

    if (!$index) {
      return response()->json([
        'message' => 'Not found'
      ] ,404);
    }

    $index->index_provider = $req->index_provider;
    $index->index_name = $req->index_name;
    $index->quality = $req->quality;
    $index->frequency = substr($req->frequency, 0, 1);

    $index->updated_at = Date('Y-m-d H:i:s');
    $index->save();

    return response()->json($index, 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id){
    $index = DB::table('index')->where('id', $id);
    $this->authorize('update', $index);
    $index->update(['status' => 'x']);

    return response()->json(['message' => 'successfully deleted'], 200);
  }

  /**
   * Retreive ALL index price of a particular index
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function indexPrice ($id, Request $req) {
    $query = IndexPrice::where([ 'index_id' => $id ])->orderBy('date', 'DESC');
    
    if($req->date) $query->where('date', '<', date('Y-m-d', strtotime($req->date)));
    if($req->latest) $query->limit(5);

    return response()->json($query->get(), 200);
  }

  /**
   * This function will return ALL index prices, transposing index name as column
   * when date not specified, ALL prices history will be given
   *
   * @param  array  $index_id
   * @param  string  $date_start
   * @param  string  $date_end
   * @param  char(1)  $frequency
   * @return \Illuminate\Http\Response
   */
  public function price(Request $req){
  	$indices = $req->indexId;
  	$date_start = $req->date_start;
  	$date_end = $req->date_end;
  	$frequency = $req->frequency;

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

  /**
   * This function will return index prices of ONE certain index in specified tima range
   * when date not specified, ALL prices history will be given
   *
   * @param  int  $index_id
   * @param  string  $date_start
   * @param  string  $date_end
   * @param  char(1)  $frequency
   * @return \Illuminate\Http\Response
   */
  public function singlePrice(Request $req){
  	$index = $req->indexId;
  	$date_start = $req->date_start;
  	$date_end = $req->date_end;
  	$frequency = $req->frequency;

    $interval = date_diff(date_create($date_start), date_create($date_end));

    // if more than 1 year, bandingin per taon
    if($interval->y > 0){
      while ($date_start < $date_end) {
        $date_end_series = date('Y-m-d', strtotime($date_start . ' +1year -1day'));


        $query = DB::table('index_price')
          ->select(DB::raw('MAX(date) "date", AVG(price) "price"'))
          ->where('index_id', $index)
          ->orderBy('date', 'DESC');

        $query->where('date', '>=', $date_start);
        $query->where('date', '<=', $date_end_series > $date_end ? $date_end : $date_end_series);

        switch($frequency){
          case 'daily' : $query->groupBy('day_of_year', 'year'); break;
          case 'weekly' : $query->groupBy('week', 'year'); break;
          case 'monthly' : $query->groupBy('month', 'year'); break;
        }

        //add dataset to the resultset
        $result[date('Y', strtotime($date_start))] = $query->get();

        //add one year for next iterations
        $date_start = date('Y-m-d', strtotime($date_start . ' +1 year'));
      }
    } else {
      //if less than 1 year, then just go with usual plotting algorithm, compare last year
      for($x=0; $x<3; $x++){
        $query = DB::table('index_price')
          ->select(DB::raw('MAX(date) "date", AVG(price) "price"'))
          ->where('index_id', $index)
          ->orderBy('date', 'DESC');

        $query->where('date', '>=', $date_start);
        $query->where('date', '<=', $date_end);

        switch($frequency){
          case 'daily' : $query->groupBy('day_of_year', 'year'); break;
          case 'weekly' : $query->groupBy('week', 'year'); break;
          case 'monthly' : $query->groupBy('month', 'year'); break;
        }
        $result[date('Y', strtotime($date_start))] = $query->get();
   
        $date_start = date('Y-m-d', strtotime($date_start . ' -1 year'));
        $date_end = date('Y-m-d', strtotime($date_end . ' -1 year'));
      }
    }

    return response()->json($result , 200);
  }

  /**
   * This function will return ALL indices that exist on specified date
   * when date not specified, all latest record are added
   *
   * @param  string  $date
   * @param  bool  $envelope
   * @return \Illuminate\Http\Response
   */
  public function singleDate(Request $req){
    $query = DB::table('index_price AS ip1')
      ->select('index.id', 'index_provider', 'index_name', 'frequency', 'ip1.updated_at', 'ip1.date', 'ip1.price')
      ->join('index', 'ip1.index_id', '=', 'index.id')
      ->orderBy('index.id');

    $lastMonth = date('Y-m-t', strtotime($req->date));
    $day = date('l', strtotime($req->date));
    if($day == "Friday"){      
      $friday = date('Y-m-d', strtotime($req->date));
    }else if($day == "Saturday" || $day == "Sunday"){
      $friday = date('Y-m-d', strtotime($req->date.' last friday'));
    }else{
      $friday = date('Y-m-d', strtotime($req->date.' next friday'));
    }
    if($req->date){
     $query->where('date', '=', date('Y-m-d', strtotime($req->date)))
          ->orWhere(function($q) use ($friday){
            $q->where('frequency', '=', 'w')
              ->where('date', '=',$friday);
          })
          ->orWhere(function($q) use ($lastMonth){
            $q->where('frequency', '=', 'm')
              ->where('date', '=',$lastMonth);
          });
    }else{
     $query->join(DB::raw('(select index_id, MAX(date) AS date FROM index_price GROUP BY index_id) as ip2'),
      function($join){
        $join->on('ip1.index_id', '=', 'ip2.index_id')
          ->on('ip1.date', '=', 'ip2.date');
      });
    }

    if($req->m){
      $query->where('frequency', '=', 'a');    
    }
    // echo $query->toSql();


    $result = $query->get();
    if($req->envelope) $result = [ 'indices' => $result ];

    if($req->previousPrice){
      foreach($result as $r){
        $latest = DB::table('index_price')
          ->select('price')
          ->where('index_id', $r->id)
          ->orderBy('date', 'DESC')
          ->limit(50)
          ->get();
        $r->latest = $latest->pluck('price');
      }
    }
        
    return response()->json($result, 200);
  }

  public function storeSingleDate(Request $req){
    $date = strtotime($req->date);    
    $lastMonth = strtotime(date('Y-m-t', strtotime($req->date)));
    $day = date('l', strtotime($req->date));
    if($day == "Friday"){      
      $friday = strtotime(date('Y-m-d', strtotime($req->date)));
    }else if($day == "Saturday" || $day == "Sunday"){
      $friday = strtotime(date('Y-m-d', strtotime($req->date.' last friday')));
    }else{
      $friday = strtotime(date('Y-m-d', strtotime($req->date.' next friday')));
    }

    $day_of_year = date('z', $date);
    $friday_day_of_year = date('z', $friday);
    $lastMonth_day_of_year = date('z', $lastMonth);

    $day_of_month = date('j', $date);
    $friday_day_of_month = date('j', $friday);
    $lastMonth_day_of_month = date('j', $lastMonth);

    $day_of_week = date('N', $date);
    $friday_day_of_week = date('N', $friday);
    $lastMonth_day_of_week = date('N', $lastMonth);

    $week = date('W', $date);
    $friday_week = date('W', $friday);
    $lastMonth_week = date('W', $lastMonth);

    $month = date('m', $date);
    $friday_month = date('m', $friday);
    $lastMonth_month = date('m', $lastMonth);

    $year = date('Y', $date);
    $friday_year = date('Y', $friday);
    $lastMonth_year = date('Y', $lastMonth);

    $date = date('Y-m-d', $date);
    $friday = date('Y-m-d', $friday);
    $lastMonth = date('Y-m-d', $lastMonth);

    $is_autogenerated = false;    
      
    foreach ($req->value as $key => $price) {
      if($price){        
        $query = DB::table('index')
          ->select('index.frequency')
          ->where('index.id', '=', $key)  
          ->orderBy('index.id');
        $frequency = $query->get();         
        if($price<>null){          
          foreach($frequency as $a => $b){
            $frequency = $b->frequency;
          }
          // echo $frequency;
        }
        
        if($frequency=='d'){          
          $indexPrice = IndexPrice::updateOrCreate(
            [ 'date' => $date, 'index_id' => $key ],
            [ 
              'price' => $price,
              'day_of_year' => $day_of_year,
              'day_of_month' => $day_of_month,
              'day_of_week' => $day_of_week,
              'week' => $week,
              'month' => $month,
              'year' => $year,
              'is_autogenerated' =>  $is_autogenerated
            ]
          );        
        }else if($frequency=='w'){
          $indexPrice = IndexPrice::updateOrCreate(
            [ 'date' => $friday, 'index_id' => $key ],
            [ 
              'price' => $price,
              'day_of_year' => $friday_day_of_year,
              'day_of_month' => $friday_day_of_month,
              'day_of_week' => $friday_day_of_week,
              'week' => $friday_week,
              'month' => $friday_month,
              'year' => $friday_year,
              'is_autogenerated' =>  $is_autogenerated
            ]
          );
        }else if($frequency=='m'){
          $indexPrice = IndexPrice::updateOrCreate(
            [ 'date' => $lastMonth, 'index_id' => $key ],
            [ 
              'price' => $price,
              'day_of_year' => $lastMonth_day_of_year,
              'day_of_month' => $lastMonth_day_of_month,
              'day_of_week' => $lastMonth_day_of_week,
              'week' => $lastMonth_week,
              'month' => $lastMonth_month,
              'year' => $lastMonth_year,
              'is_autogenerated' =>  $is_autogenerated
            ]
          );
        }
      }
    }    
  
        


    return response()->json($req,200);
  }
}

