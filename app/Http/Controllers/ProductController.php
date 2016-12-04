<?php

namespace App\Http\Controllers;

use App\Model\Product;

use Illuminate\Http\Request;

use App\Http\Requests;

class ProductController extends Controller
{
  public function __construct() {
    // $this->middleware('jwt.auth');
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $product = Product::where('status', 'a')->get();

    return response()->json($product, 200);
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

    $product = new Product($req->only([
      'product_name', 'typical_quality',
      'gcv_arb_min', 'gcv_arb_max', 'gcv_adb_min', 'gcv_adb_max', 'ncv_min', 'ncv_max',
      'ash_min', 'ash_max', 'ts_min', 'ts_max', 'tm_min', 'tm_max', 'im_min', 'im_max',
      'fc_min', 'fc_max', 'vm_min', 'vm_max', 'hgi_min', 'hgi_max', 'size_min', 'size_max',
      'fe2o3_min', 'fe2o3_max', 'aft_min', 'aft_max',
    ]));

    $product->company_id = $req->company_id ? $req->company_id : NULL;
    $product->concession_id = $req->concession_id ? $req->concession_id : NULL;

    $product->status = 'a';
    $product->save();

    return response()->json($product, 200);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $product = Product::with('concession', 'company')->find($id);

    if($product->status != 'a') return response()->json(['message' => 'deactivated record'], 404);
    
    return response()->json($product, 200);
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
    $product = Product::find($id);

    if (!$req) return response()->json([ 'message' => 'Bad Request' ], 400);
    if (!$product) return response()->json([ 'message' => 'Not found' ] ,404);

    $product->fill($req->only([
      'product_name', 'typical_quality',
      'gcv_arb_min', 'gcv_arb_max', 'gcv_adb_min', 'gcv_adb_max', 'ncv_min', 'ncv_max',
      'ash_min', 'ash_max', 'ts_min', 'ts_max', 'tm_min', 'tm_max', 'im_min', 'im_max',
      'fc_min', 'fc_max', 'vm_min', 'vm_max', 'hgi_min', 'hgi_max', 'size_min', 'size_max',
      'fe2o3_min', 'fe2o3_max', 'aft_min', 'aft_max',
    ]));

    $product->company_id = $req->company_id ? $req->company_id : NULL;
    $product->concession_id = $req->concession_id ? $req->concession_id : NULL;

    $product->save();

    return response()->json($product, 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($product)
  {
    $product = Product::find($product);
   
    if (!$product) {
      return response()->json([
        'message' => 'Not found'
      ] ,404);
    }

    $product->status = 'x';
    $product->save();

    return response()->json($product, 200);
  }
}
