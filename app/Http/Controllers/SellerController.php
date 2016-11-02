<?php

namespace App\Http\Controllers;

use App\Model\Seller;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use App\Events\InputEditCoalpedia;

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
    public function index(Request $request)
    {
        $seller = Seller::where('status', 'a');
        if ($request->q) $seller->where('company_name', 'LIKE', '%'.$request->q.'%');
        $seller = $seller->get();

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
        $seller->user_id = Auth::User()->id;
        $seller->company_name = $request->company_name;
        $seller->is_trader = $request->is_trader;
        $seller->is_affiliated = $request->is_affiliated;
        $seller->contact_person = $request->contact_person;
        $seller->phone = $request->phone;
        $seller->email = $request->email;
        $seller->web = $request->web;
        $seller->address = $request->address;
        $seller->city = $request->city;
        $seller->country = $request->country;
        $seller->latitude = $request->latitude;
        $seller->longitude = $request->longitude;
        $seller->industry = $request->industry;
        $seller->total_annual_sales = $request->total_annual_sales;
        $seller->preferred_trading_term = $request->preferred_trading_term;
        $seller->preferred_payment_term = $request->preferred_payment_term; 
        $seller->purchasing_countries = $request->purchasing_countries;
        $seller->description = $request->description;
        $seller->status = 'a';
        $seller->save();

        // event(new InputEditCoalpedia(Auth::user(), $seller->id, 'sellers', 'create'));

        return response()->json($seller, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $seller = Seller::with(
                            'Concession', 'Contact', 'User', 'Product'
                             )->find($id);

        if($seller) {
            if($seller->status == 'a') {
                return response()->json($seller, 200);
            } else {
                return response()->json(['message' => 'deactivated record'], 404);
            }
        } else {
            return response()->json('Not found', 404);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $seller)
    {
        $seller = Seller::find($seller);

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

        $seller->user_id = $request->user_id;
        $seller->company_name = $request->company_name;
        $seller->is_trader = $request->is_trader;
        $seller->is_affiliated = $request->is_affiliated;
        $seller->contact_person = $request->contact_person;
        $seller->phone = $request->phone;
        $seller->email = $request->email;
        $seller->web = $request->web;
        $seller->address = $request->address;
        $seller->city = $request->city;
        $seller->country = $request->country;
        $seller->latitude = $request->latitude;
        $seller->longitude = $request->longitude;
        $seller->industry = $request->industry;
        $seller->total_annual_sales = $request->total_annual_sales;
        $seller->preferred_trading_term = $request->preferred_trading_term;
        $seller->preferred_payment_term = $request->preferred_payment_term; 
        $seller->purchasing_countries = $request->purchasing_countries;
        $seller->description = $request->description;

        $seller->status = $request->status;
        $seller->save();

        event(new InputEditCoalpedia(Auth::user(), $seller->id, 'sellers', 'update'));

        return response()->json($seller, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($seller)
    {
        $seller = Seller::find($seller);
        
        if (!$seller) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $seller->status = 'x';
        $seller->save();

        return response()->json($seller, 200);
    }

    public function getSellerByName($name) {
        $seller = Seller::wherewhere('company_name', 'like', '%'.$name.'%')->get();

        return response()->json($seller, 200);
    }

    public function getTotalSeller() {
        $total = Seller::count();
        $status = array('count' => $total);        
        return response()->json($status, 200);
    }
}
