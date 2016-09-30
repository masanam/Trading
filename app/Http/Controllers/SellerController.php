<?php

namespace App\Http\Controllers;

use App\Model\Seller;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

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
    public function index($search = false)
    {
        if (!$search) {
            $seller = Seller::where('status', 'a')->get();
        } else {
            $seller = Seller::where('status', 'a')->where('company_name', 'LIKE', '%'.$search.'%')->get();
        }

        return response()->json($seller, 200);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search($search = false)
    {
        if (!$search) {
            $seller = Seller::where('status', 'a')->get();
        } else {
            $seller = Seller::where('status', 'a')->where('company_name', 'LIKE', '%'.$search.'%')->get();
        }

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
        $seller->phone = $request->phone;
        $seller->email = $request->email;
        $seller->web = $request->web;
        $seller->industry = $request->industry;
        $seller->city = $request->city;
        $seller->address = $request->address;
        $seller->latitude = $request->latitude;
        $seller->longitude = $request->longitude;
        $seller->description = $request->description;
        $seller->status = 'a';
        $seller->save();

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
                            'Mine', 'Contact', 'User', 'Product'
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

        $seller->user_id = $request->user_id;
            
        $seller->company_name = $request->company_name;

        $seller->phone = $request->phone;
        $seller->email = $request->email;
        $seller->web = $request->web;

        $seller->industry = $request->industry;

        $seller->city = $request->city;
        $seller->address = $request->address;

        $seller->latitude = $request->latitude;
        $seller->longitude = $request->longitude;

        $seller->description = $request->description;

        $seller->status = $request->status;
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
