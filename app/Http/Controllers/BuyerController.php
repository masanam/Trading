<?php

namespace App\Http\Controllers;

use App\Model\Buyer;
use App\Model\Contact;
use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\BuyOder;

use App\Events\InputEditCoalpedia;

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
    public function index(Request $request)
    {
        $buyer = Buyer::with('BuyOrder', 'User')->where('status', 'a');
        if ($request->q) $buyer->where('company_name', 'LIKE', '%'.$request->q.'%');
        $buyer = $buyer->get();
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
        $buyer->user_id = Auth::user()->id;
        $buyer->company_name = $request->company_name;
        $buyer->is_trader = $request->is_trader;
        $buyer->is_affiliated = $request->is_affiliated;
        $buyer->phone = $request->phone;
        $buyer->email = $request->email;
        $buyer->web = $request->web;
        $buyer->address = $request->address;
        $buyer->city = $request->city;
        $buyer->country = $request->country;
        $buyer->latitude = $request->latitude;
        $buyer->longitude = $request->longitude;
        $buyer->industry = $request->industry;
        $buyer->annual_demand = $request->annual_demand;
        $buyer->preferred_trading_term = $request->preferred_trading_term;
        $buyer->preferred_trading_term_detail = $request->preferred_trading_term_detail;
        $buyer->preferred_payment_term = $request->preferred_payment_term; 
        $buyer->description = $request->description;
        $buyer->status = 'a';
        $buyer->save();

        event(new InputEditCoalpedia(Auth::user(), $buyer->id, 'buyers', 'create'));

        return response()->json($buyer, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$buyer = Contact::find([1,2,3,4,5]);
        $buyer = Buyer::with(['Contact' => function($q) {
                            $q->where('contacts.status', 'a');
                          },'Product' => function($q) {
                            $q->where('products.status', 'a');
                          },'Factory' => function($q) {
                            $q->where('factory.status', 'a');
                          }])->find($id);

        if($buyer->status == 'a') {
            return response()->json($buyer, 200);
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
    public function update(Request $request, $buyer)
    {
        $buyer = Buyer::find($buyer);
     
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
        $buyer->is_trader = $request->is_trader;
        $buyer->is_affiliated = $request->is_affiliated;
        $buyer->phone = $request->phone;
        $buyer->email = $request->email;
        $buyer->web = $request->web;
        $buyer->address = $request->address;
        $buyer->city = $request->city;
        $buyer->country = $request->country;
        $buyer->latitude = $request->latitude;
        $buyer->longitude = $request->longitude;
        $buyer->industry = $request->industry;
        $buyer->annual_demand = $request->annual_demand;
        $buyer->preferred_trading_term = $request->preferred_trading_term;
        $buyer->preferred_trading_term_detail = $request->preferred_trading_term_detail;
        $buyer->preferred_payment_term = $request->preferred_payment_term; 
        $buyer->description = $request->description;
        $buyer->status = $request->status;
        $buyer->save();

        event(new InputEditCoalpedia(Auth::user(), $buyer->id, 'buyers', 'update'));

        return response()->json($buyer, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($buyer)
    {
        $buyer = Buyer::find($buyer);
     
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

    public function getTotalBuyer() {
        $total = Buyer::count();
        $status = array('count' => $total);        
        return response()->json($status,200);
    }

}
