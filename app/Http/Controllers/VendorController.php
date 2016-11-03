<?php

namespace App\Http\Controllers;

use App\Model\Vendor;
use Illuminate\Http\Request;

use App\Http\Requests;

class VendorController extends Controller
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
        $vendor = Vendor::where('status', 'a');
        if ($request->q) $vendor->where('company_name', 'LIKE', '%'.$request->q.'%');
        $vendor = $vendor->get();

        return response()->json($vendor, 200);
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

        $vendor = new Vendor();
        $vendor->company_name = $request->company_name;
            
        $vendor->phone = $request->phone;
        $vendor->email = $request->email;
        $vendor->web = $request->web;

        $vendor->industry = $request->industry;

        $vendor->city = $request->city;
        $vendor->address = $request->address;

        $vendor->description = $request->description;

        $vendor->status = 'a';
        $vendor->save();

        return response()->json($vendor, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($vendor)
    {
        $vendor = Vendor::find($vendor);

        if($vendor->status == 'a') {
            return response()->json($vendor, 200);
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
    public function update(Request $request, $vendor)
    {
        $vendor = Vendor::find($vendor);

        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$vendor) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $vendor->company_name = $request->company_name;

        $vendor->phone = $request->phone;
        $vendor->email = $request->email;
        $vendor->web = $request->web;

        $vendor->industry = $request->industry;

        $vendor->city = $request->city;
        $vendor->address = $request->address;

        $vendor->description = $request->description;

        $vendor->save();

        return response()->json($vendor, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($vendor)
    {
        $vendor = Vendor::find($vendor);

        if (!$vendor) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $vendor->status = 'x';
        $vendor->save();

        return response()->json($vendor, 200);
    }

    public function getVendorByName($name) {
        $vendor = Buyer::wherewhere('company_name', 'like', '%'.$name.'%')->get();

        return response()->json($vendor, 200);
    }

    public function getTotalVendor() {
        $total = Vendor::count();
        $status = array('count' => $total);        
        return response()->json($status, 200);
    }
}
