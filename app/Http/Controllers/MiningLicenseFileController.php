<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\MiningLicenseFile;
use Auth;

use App\Http\Requests;
use DB;

class MiningLicenseFileController extends Controller
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
        $license = MiningLicenseFile::with('mining_license_files')->select('id','mining_license','url','upload_by','create_at','update_at');
      

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

        $license = new MiningLicenseFile($req->all());
        $license->created_by = Auth::User()->id;
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

        $license = MiningLicenseFile::with('mining_license')->select('*', DB::raw('ST_AsGeoJSON(polygon, 8) AS polygon'))->where('mining_lisense_id',$id)->first();

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
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
