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
        $Seller = Seller::where('status', 'a')->get();

        return response()->json($Seller, 200);
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

        $Seller = new Seller();
        $Seller->user_id = $request->user_id;
            
        $Seller->company_name = $request->company_name;

        $Seller->phone = $request->phone;
        $Seller->email = $request->email;
        $Seller->web = $request->web;

        $Seller->industry = $request->industry;

        $Seller->city = $request->city;
        $Seller->address = $request->address;

        $Seller->latitude = $request->latitude;
        $Seller->longitude = $request->longitude;

        $Seller->description = $request->description;

        $Seller->status = $request->status;
        $Seller->save();

        return response()->json($Seller, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $Seller)
    {
        if($Seller->status == 'a') {
            return response()->json($Seller, 200);
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
    public function update(Request $request, Seller $Seller)
    {
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$Seller) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $Seller->user_id = $request->user_id;
            
        $Seller->company_name = $request->company_name;

        $Seller->phone = $request->phone;
        $Seller->email = $request->email;
        $Seller->web = $request->web;

        $Seller->industry = $request->industry;

        $Seller->city = $request->city;
        $Seller->address = $request->address;

        $Seller->latitude = $request->latitude;
        $Seller->longitude = $request->longitude;

        $Seller->description = $request->description;

        $Seller->status = $request->status;
        $Seller->save();

        return response()->json($Seller, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $Seller)
    {
        if (!$Seller) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $Seller->status = 'x';
        $Seller->save();

        return response()->json($Seller, 200);
    }
}
