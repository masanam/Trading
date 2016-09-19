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

        $buyer = Buyer::where('status', 'a')->get();
        return response()->json($buyer, 200);
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

        $buyer = new Buyer();
        $buyer->user_id = $request->user_id;

        $buyer->company_name = $request->company_name;
        
        $buyer->phone = $request->phone;
        $buyer->email = $request->email;
        $buyer->web = $request->web;

        $buyer->industry = $request->industry;

        $buyer->city = $request->city;
        $buyer->address = $request->address;

        $buyer->latitude = $request->latitude;
        $buyer->longitude = $request->longitude;

        $buyer->description = $request->description;

        $buyer->status = $request->status;
        $buyer->save();

        return response()->json($buyer, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer)
    {
<<<<<<< HEAD
        if($buyer->status == 'a') {
            return response()->json($buyer, 200);
        } else {
            return response()->json(['message' => 'deactivated record'], 404);
=======
        if($Buyer->status == 'a') {
            return response()->json($Buyer, 200);
        } else {
            return response()->json(['message' => 'deleted'], 404);
>>>>>>> b2ec0e9fc90dcffd481a1157ff7620b95306027d
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Buyer $buyer)
    {
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$buyer) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $buyer->user_id = $request->user_id;

        $buyer->company_name = $request->company_name;
        
        $buyer->phone = $request->phone;
        $buyer->email = $request->email;
        $buyer->web = $request->web;

        $buyer->industry = $request->industry;

        $buyer->city = $request->city;
        $buyer->address = $request->address;

        $buyer->latitude = $request->latitude;
        $buyer->longitude = $request->longitude;

        $buyer->description = $request->description;

        $buyer->status = $request->status;
        $buyer->save();

        return response()->json($buyer, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Buyer $buyer)
    {
        if (!$buyer) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $buyer->status = 'x';
        $buyer->save();

        return response()->json($buyer, 200);
    }

    public function getBuyerByName($name) {
        $buyer = Buyer::where('company_name', 'like', '%'.$name.'%')->get();

        return response()->json($buyer, 200);
    }
}
