<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\MiningLicense;
use Auth;

use App\Http\Requests;
use DB;

class MiningLicenseController extends Controller
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
        $license = MiningLicense::with('Company','Contact')->select('*', DB::raw('ST_AsGeoJSON(polygon, 8) AS polygon'))->where('status', 'a')->get();

        return response()->json($license, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        if(!$req) {
          return response()->json([
            'message' => 'Bad Request'
          ], 400);
        }

        $license = new MiningLicense($req->all());
        $license->created_by = Auth::User()->id;
        if($req->polygon) $license->polygon = DB::raw('GeomFromText(\'POLYGON('.$req->polygon.')\')');
        $license->status = 'a';
        $license->save();

        return response()->json($license, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $license = MiningLicense::select('*', DB::raw('ST_AsGeoJSON(polygon, 8) AS polygon'))->where('id',$id)->where('status', 'a')->first();

        return response()->json($license, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        if(!$req) {
          return response()->json([
            'message' => 'Bad Request'
          ], 400);
        }
        $license = MiningLicense::find($id);
        $license->fill($req->all());
        if($req->polygon) $license->polygon = DB::raw('GeomFromText(\'POLYGON('.$req->polygon.')\')');
        $license->save();

        return response()->json($license, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $license = MiningLicense::find($id);

        if (!$license) {
          return response()->json([
            'message' => 'Not found'
          ] ,404);
        }

        $license->status = 'x';
        $license->save();

        return response()->json($license, 200);
    }
}
