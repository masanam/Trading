<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Model\Index;
use App\Model\IndexPrice;

use App\Http\Requests;


class IndexPriceController extends Controller
{
  public function __construct() {
      $this->middleware('jwt.auth');
  }

  public function index (Request $req) {
    $query = IndexPrice::where('status','a')->orderBy('date', 'DESC');

    if($req->value) {
      $query = $query->where('index_id',$req->value);
    }

    if($req->year){
      $query = $query->where(DB::raw('YEAR(date)'),'=',$req->year);
    }

    if($req->month){
      $query = $query->where(DB::raw('MONTH(date)'),'=',$req->month);
    }


    // echo $query->toSql();
    // dd();

    return response()->json($query->get(), 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */

  public function store(Request $request)
  {
    if(!$request) {
      return response()->json([
        'message' => 'Bad Request'
      ], 400);
    }

    $indexPrice = new IndexPrice();
    $this->authorize('create', $indexPrice);
    $indexPrice->index_id = $request->index_id;
    $indexPrice->price = $request->prices;
    $indexPrice->date = date("Y-m-d",strtotime($request->date));
    $indexPrice->year = date("Y",strtotime($request->date));
    $indexPrice->month = date("m",strtotime($request->date));
    $indexPrice->week = date("W",strtotime($request->date));
    $indexPrice->day_of_year = date("z",strtotime($request->date));
    $indexPrice->day_of_month = date("j",strtotime($request->date));
    $indexPrice->day_of_week = date("N",strtotime($request->date));
    $indexPrice->status = 'a';

    //date logic masuk sini
    //$indexPrice->quality = $request->quality;

    $indexPrice->created_at = Date('Y-m-d H:i:s');
    $indexPrice->updated_at = Date('Y-m-d H:i:s');
    $indexPrice->save();

    return response()->json($indexPrice, 200);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $indexPrice = IndexPrice::find($id);
    return response()->json($indexPrice, 200);
  }

  /**
   * Updates a particular index price
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $indexPrice = IndexPrice::find($id);
    // $this->authorize('update', $indexPrice);
    //
    // if (!$request) {
    //   return response()->json([
    //     'message' => 'Bad Request'
    //   ], 400);
    // }
    //
    // if (!$indexPrice) {
    //   return response()->json([
    //     'message' => 'Not found'
    //   ] ,404);
    // }

    $indexPrice->date = date('Y-m-d', strtotime($request->date));
    $indexPrice->price = $request->price;
    $indexPrice->updated_at = Date('Y-m-d H:i:s');
    $indexPrice->save();

    return response()->json($indexPrice, 200);
  }

  public function destroy($id){
    $indexPrice = IndexPrice::find($id);

    if (!$indexPrice) {
        return response()->json([
            'message' => 'Not found'
        ] ,404);
    }

    $indexPrice->status = 'x';
    $indexPrice->save();
    return response()->json($indexPrice, 200);
  }
}
