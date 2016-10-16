<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

  public function singleIndex(Request $request, $id)
  {
    $indexPrices = IndexPrice::select('date', 'price')->where('index_id', $id);

    if($request->date_start) $indexPrices->where('date', '>=', $request->date_start);
    if($request->date_end) $indexPrices->where('date', '<=', $request->date_end);

    $indexPrices = $indexPrices->get();
    return response()->json($indexPrices, 200);
  }
}
