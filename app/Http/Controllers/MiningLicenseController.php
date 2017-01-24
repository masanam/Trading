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
    public function index(Request $req = null)
    {
        $license = MiningLicense::with('Company','Contact','checked_by')->select('id','company_id','source','contact_id','type','status','checked_by','checked_at','expired','overlap_other','release_after','is_corrupt','is_operating','close_to_sinarmas_factory','close_to_sinarmas_concession','close_to_river','close_to_other_concession','coal_bearing_formation','is_mining_zone','is_settlement_zone','is_palm_plantation','is_farming_zone','is_sinarmas_forestry');
        if($req->draft) $license->whereIn('status',[1, 2, 3]);
        else $license->whereNotIn('status',[1, 2, 3]);
        $license = $license->get();
        foreach ($license as $l) {
            if($l->expired > Date('Y-m-d')) $l->filter_expired = 0;
            else $l->filter_expired = 1;
            if(!$l->coal_bearing_formation) $l->filter_coal_bearing = 0;
            else $l->filter_coal_bearing = 1;
            if($l->status == 1 || $l->status == 2 || $l->status == 3) $l->filter_draft = 1;
            else $l->filter_draft = 0;
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

        return $this->show($license->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $license = MiningLicense::with('Company','Contact','Concession','Concession.port','checked_by','spatial_data')->select('*', DB::raw('ST_AsGeoJSON(polygon, 8) AS polygon'))->where('id',$id)->first();

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
        $license->expired = date('Y-m-d',strtotime($req->expired));
        $license->checked_at = date('Y-m-d',strtotime($req->checked_at));
        $license->updated_at = date('Y-m-d',strtotime($req->updated_at));
        if($req->polygon) $license->polygon = DB::raw('GeomFromText(\'POLYGON('.$req->polygon.')\')');

        if($req->overlay){
            $license->spatial_data()->sync($req->overlay);
        }

        $license->save();

        return $this->show($license->id);
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
