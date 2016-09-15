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
        $vendor = Vendor::get();

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
        $vendor->name = $request->name;
        $vendor->image = $request->image;
        $vendor->title = $request->title;
        $vendor->email = $request->email;
        $vendor->phone = $request->phone;
        $vendor->save();

        return response()->json($vendor, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        return response()->json($vendor, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
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

        $vendor->name = $request->name;
        $vendor->image = $request->image;
        $vendor->title = $request->title;
        $vendor->email = $request->email;
        $vendor->phone = $request->phone;

        $vendor->save();

        return response()->json($vendor, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        if (!$vendor) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $vendor->status = 'x';
        $vendor->save();

        return response()->json($vendor, 200);
    }
}
