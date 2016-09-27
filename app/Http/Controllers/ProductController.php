<?php

namespace App\Http\Controllers;

use App\Model\Product;

use Illuminate\Http\Request;

use App\Http\Requests;

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
    public function index()
    {
        $product = Product::where('status', 'a')->get();

        return response()->json($product, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search($search = false)
    {
        if (!$search) {
            $product = Product::where('status', 'a')->get();
        } else {
            $product = Product::where('status', 'a')->where('product_name', 'LIKE', '%'.$search.'%')->get();
        }

        return response()->json($product, 200);
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

        $product = new Product();
        $product->name = $request->name;
        $product->image = $request->image;
        $product->title = $request->title;
        $product->email = $request->email;
        $product->phone = $request->phone;
        $product->save();

        return response()->json($product, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        if($product->status == 'a') {
            return response()->json($product, 200);
        } else {
            return response()->json(['message' => 'deactivated record'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$product) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $product->name = $request->name;
        $product->image = $request->image;
        $product->title = $request->title;
        $product->email = $request->email;
        $product->phone = $request->phone;

        $product->save();

        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if (!$product) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $product->status = 'x';
        $product->save();

        return response()->json($product, 200);
    }

    public function getTotalProduct() {
        $total = Product::count();
        $status = array('count' => $total);        
        return response()->json($status,200);
    }
}
