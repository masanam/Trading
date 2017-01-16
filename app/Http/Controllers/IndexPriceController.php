<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Model\Index;
use App\Model\IndexPrice;

use App\Http\Requests;


class IndexPriceController extends Controller
{

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
    
    $indexPrice->date = $request->date;
    $indexPrice->index_id = $request->index_id;
    $indexPrice->price = $request->price;

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
    if(!$indexPrice) return response()->json([ 'message' => 'Not Found' ], 404);
    return response()->json($indexPrice, 200);
  }

  /**
   * Updates a particular index price
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)r
  {
    $indexPrice = IndexPrice::find($id);

    if (!$request) {
      return response()->json([
        'message' => 'Bad Request'
      ], 400);
    }

    if (!$indexPrice) {
      return response()->json([
        'message' => 'Not found'
      ] ,404);
    }

    $indexPrice->date = date('Y-m-d', strtotime($request->date));
    $indexPrice->price = $request->price;
    $indexPrice->updated_at = Date('Y-m-d H:i:s');
    $indexPrice->save();

    return response()->json($indexPrice, 200);
  }
}