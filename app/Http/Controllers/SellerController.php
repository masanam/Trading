<?php

namespace App\Http\Controllers;

use App\Model\Seller;

use Illuminate\Http\Request;

use App\Http\Requests;

class SellerController extends Controller
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
        $seller = Seller::get();

        return response()->json($seller, 200);
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

        $seller = new Seller();
        $seller->name = $request->name;
        $seller->image = $request->image;
        $seller->title = $request->title;
        $seller->email = $request->email;
        $seller->phone = $request->phone;
        $seller->save();

        return response()->json($seller, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller)
    {
        return response()->json($seller, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller)
    {
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$seller) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $seller->name = $request->name;
        $seller->image = $request->image;
        $seller->title = $request->title;
        $seller->email = $request->email;
        $seller->phone = $request->phone;

        $seller->save();

        return response()->json($seller, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller)
    {
        if (!$seller) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $seller->status = 'x';
        $seller->save();

        return response()->json($seller, 200);
    }
}
