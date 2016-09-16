<?php

namespace App\Http\Controllers;

use App\Model\Buyer;

use Illuminate\Http\Request;

use App\Http\Requests;

class BuyerController extends Controller
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
        $Buyer = Buyer::where('status', 'a')->get();

        return response()->json($Buyer, 200);
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

        $Buyer = new Buyer();
        $Buyer->user_id = $request->user_id;

        $Buyer->company_name = $request->company_name;
        
        $Buyer->phone = $request->phone;
        $Buyer->email = $request->email;
        $Buyer->web = $request->web;

        $Buyer->industry = $request->industry;

        $Buyer->city = $request->city;
        $Buyer->address = $request->address;

        $Buyer->latitude = $request->latitude;
        $Buyer->longitude = $request->longitude;

        $Buyer->description = $request->description;

        $Buyer->status = $request->status;
        $Buyer->save();

        return response()->json($Buyer, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $Buyer)
    {
        if($Buyer->status == 'a') {
            return response()->json($Buyer, 200);
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
    public function update(Request $request, Buyer $Buyer)
    {
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$Buyer) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $Buyer->user_id = $request->user_id;

        $Buyer->company_name = $request->company_name;
        
        $Buyer->phone = $request->phone;
        $Buyer->email = $request->email;
        $Buyer->web = $request->web;

        $Buyer->industry = $request->industry;

        $Buyer->city = $request->city;
        $Buyer->address = $request->address;

        $Buyer->latitude = $request->latitude;
        $Buyer->longitude = $request->longitude;

        $Buyer->description = $request->description;

        $Buyer->status = $request->status;
        $Buyer->save();

        return response()->json($Buyer, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Buyer $Buyer)
    {
        if (!$Buyer) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $Buyer->status = 'x';
        $Buyer->save();

        return response()->json($Buyer, 200);
    }
}
