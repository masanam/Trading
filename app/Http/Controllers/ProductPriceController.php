<?php

namespace App\Http\Controllers;

use App\Model\ProductPrice;
use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class ProductPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {   
        $productprice = ProductPrice::with('Product')->where('status', 'a');
        if($req->product_id){
            $productprice->where('product_id', $req->product_id);    
        }
        

        return response()->json($productprice->get(), 200);
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

        $productprice = new ProductPrice();
        $productprice->product_id = $req->product_id ? $req->product_id : NULL;
        $productprice->date = $req->date;
        $productprice->barging = $req->barging;
        $productprice->discount = $req->discount;
        $productprice->price = $req->price;
        $productprice->status = 'a';
        $productprice->save();

        return response()->json($productprice, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductPrice  $productPrice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productprice = ProductPrice::with('Product')->find($id);  
        return response()->json($productprice, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductPrice  $productPrice
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductPrice $productPrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductPrice  $productPrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductPrice $productPrice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductPrice  $productPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductPrice $productPrice)
    {
        //
    }
}
