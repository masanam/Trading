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
        $Product = Product::where('status', 'a')->get();

        return response()->json($Product, 200);
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

        $Product = new Product();
        $Product->name = $request->name;
        $Product->image = $request->image;
        $Product->title = $request->title;
        $Product->email = $request->email;
        $Product->phone = $request->phone;
        $Product->save();

        return response()->json($Product, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $Product)
    {
        if($Product->status == 'a') {
            return response()->json($Product, 200);
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
    public function update(Request $request, Product $Product)
    {
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$Product) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $Product->name = $request->name;
        $Product->image = $request->image;
        $Product->title = $request->title;
        $Product->email = $request->email;
        $Product->phone = $request->phone;

        $Product->save();

        return response()->json($Product, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $Product)
    {
        if (!$Product) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $Product->status = 'x';
        $Product->save();

        return response()->json($Product, 200);
    }
}
