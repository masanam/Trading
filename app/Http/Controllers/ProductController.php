<?php

namespace App\Http\Controllers;

use App\Model\Product;
use App\Model\ProductPrice;
use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;


class ProductController extends Controller
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
    $product = Product::with('yearlyPrice')->where('status', 'a');

    if($req->q) $product->where('product_name', 'LIKE', '%'.$req->q.'%');

    $product = $product->get();
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
    $user = Auth::User();
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
      'fe2o3_min', 'fe2o3_max', 'aft_min', 'aft_max','na2o_min','na2o_max',
    ]));

    $product->company_id = $req->company_id ? $req->company_id : NULL;
    $product->concession_id = $req->concession_id ? $req->concession_id : NULL;

    $product->user_id = $user->id;
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
    $product = Product::with(['concession'=> function ($query) {
        $query->select('id','concession_name','company_id','owner','reserves','city','country');
      }, 'company'])->find($id);

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
    $product = Product::with(['concession'=> function ($query) {
        $query->select('id','concession_name','company_id','owner','reserves','city','country');
      }, 'company'])->find($id);

    if (!$req) return response()->json([ 'message' => 'Bad Request' ], 400);
    if (!$product) return response()->json([ 'message' => 'Not found' ] ,404);

    $product->fill($req->only([
      'product_name', 'typical_quality',
      'gcv_arb_min', 'gcv_arb_max', 'gcv_adb_min', 'gcv_adb_max', 'ncv_min', 'ncv_max',
      'ash_min', 'ash_max', 'ts_min', 'ts_max', 'tm_min', 'tm_max', 'im_min', 'im_max',
      'fc_min', 'fc_max', 'vm_min', 'vm_max', 'hgi_min', 'hgi_max', 'size_min', 'size_max',
      'fe2o3_min', 'fe2o3_max', 'aft_min', 'aft_max','na2o_min','na2o_max',
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
