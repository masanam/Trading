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

    /* Kamal 2017-01-19 18:00
     * create All function CRUD
     */
    public function index()
    {
        $license = MiningLicense::with('Company','Contact','checked_by')->select('company_id','source','contact_id','type','status','checked_by','checked_at','expired','overlap_other','release_after','troubled_bupati','operating','close_factory','close_iup','close_river','close_iup_other','coal_bearing_formation','located_mining','located_settlement','located_palm','located_farm','overlay_forest')->get();
        foreach ($license as $l) {
            if($l->expired > Date('Y-m-d')) $l->filter_expired = 0;
            else $l->filter_expired = 1;
        }

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
        $license->status = '1';
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
        $license = MiningLicense::select('*', DB::raw('ST_AsGeoJSON(polygon, 8) AS polygon'))->where('id',$id)->first();

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
        if($req->status) $license->status = $req->status;
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
