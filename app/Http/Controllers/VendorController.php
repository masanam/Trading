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
    public function index()
    {
        $Vendor = Vendor::where('status', 'a')->get();

        return response()->json($Vendor, 200);
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

        $Vendor = new Vendor();
        $Vendor->company_name = $request->company_name;
            
        $Vendor->phone = $request->phone;
        $Vendor->email = $request->email;
        $Vendor->web = $request->web;

        $Vendor->industry = $request->industry;

        $Vendor->city = $request->city;
        $Vendor->address = $request->address;

        $Vendor->description = $request->description;

        $Vendor->status = 'a';
        $Vendor->save();

        return response()->json($Vendor, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $Vendor)
    {
        if($Vendor->status == 'a') {
            return response()->json($Vendor, 200);
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
    public function update(Request $request, Vendor $Vendor)
    {
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$Vendor) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $Vendor->company_name = $request->company_name;
            
        $Vendor->phone = $request->phone;
        $Vendor->email = $request->email;
        $Vendor->web = $request->web;

        $Vendor->industry = $request->industry;

        $Vendor->city = $request->city;
        $Vendor->address = $request->address;

        $Vendor->description = $request->description;

        $Vendor->status = 'a';

        $Vendor->save();

        return response()->json($Vendor, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $Vendor)
    {
        if (!$Vendor) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $Vendor->status = 'x';
        $Vendor->save();

        return response()->json($Vendor, 200);
    }
}
