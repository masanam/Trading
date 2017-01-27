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

    /* AndezTea 2017-01-19 18:00
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
        $license = MiningLicenseFile::where('status', 'a')->find($id);

        $license = DB::table('mining_license_files')->where('id', $id)->update(['status' => 'x']);

        return response()->json($license, 200);
        
    }
}
