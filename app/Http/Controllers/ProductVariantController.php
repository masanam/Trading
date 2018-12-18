<?php

namespace App\Http\Controllers;

use App\Model\ProductVariant;
use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class ProductVariantController extends Controller
{
    public function __construct()
    {
      $this->middleware('jwt.auth', [ 'except' => 'approval' ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $productvariant = ProductVariant::with('product')->where('status', 'a')->orderBy('product_id');
        // $productvariant = Product::with('product_variant')->where('status', 'a');
        if($req->pageSize){
            $limit = $req->pageSize ? $req->pageSize : 5;
            $skip = ( $req->pageSize * $req->page ) ? ( $req->pageSize * $req->page ) : 0;
        }

        if($req->product_id){
            $productvariant->where('product_id', $req->product_id);
        }

        if($req->q){
          $param = $req->q;
          $productvariant->where('name_product_variant', 'LIKE', '%'.$param.'%')
            ->orWhereHas('product' , function($q) use ($param) {
                                  $q->where('product_name', 'LIKE' , '%'.$param.'%');
                                });
        }
        if(isset($skip)){
            $productvariant = $productvariant->skip($skip)->take($limit);
        }
        return response()->json($productvariant->get(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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

        $productvariant = new ProductVariant();
        $productvariant->product_id = $req->product_id;
        $productvariant->name_product_variant = $req->name_product_variant;
        $productvariant->status = 'a';
        $productvariant->save();

        return response()->json($productvariant, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductVariant  $productVariant
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productvariant = ProductVariant::with('product')->find($id);
        return response()->json($productvariant, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductVariant  $productVariant
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductVariant $productVariant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductVariant  $productVarint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $productVariant)
    {

      $productvariant = ProductVariant::find($productVariant);

      if (!$req) return response()->json([ 'message' => 'Bad Request' ], 400);
      if (!$productvariant) return response()->json([ 'message' => 'Not found' ] ,404);

      $productvariant->product_id = $req->product_id;
      $productvariant->name_product_variant = $req->name_product_variant;

      $productvariant->save();

      return response()->json($productvariant, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductVariant  $productVariant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $productvariant = ProductVariant::where('status', 'a')->find($id);
      // return response()->json($productvariant);

      if (!$productvariant) return response()->json([ 'message' => 'Not found or Deactivated Product Variant' ] ,404);

      $productvariant->status = 'x';
      $productvariant->save();

      return response()->json($productvariant, 200);
    }
}
