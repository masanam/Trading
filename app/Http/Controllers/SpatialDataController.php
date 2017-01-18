<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\SpatialData;
use Auth;

use App\Http\Requests;
use DB;

class SpatialDataController extends Controller
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
        $data = SpatialData::with('User')->select('*', DB::raw('ST_AsGeoJSON(polygon, 8) AS polygon'))->where('status', 'a')->get();

        return response()->json($data, 200);
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

        $data = new SpatialData($req->all());
        $data->created_by = Auth::User()->id;
        $data->polygon = DB::raw('GeomFromText(\'POLYGON('.$req->polygon.')\')');
        $data->status = 'a';
        $data->save();

        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = SpatialData::select('*', DB::raw('ST_AsGeoJSON(polygon, 8) AS polygon'))->where('id',$id)->where('status', 'a')->first();

        return response()->json($data, 200);
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
        $data = SpatialData::find($id);
        $data->fill($req->all());

        $type_data=substr($req->polygon, 0,strpos($req->polygon, '('));

        echo $type_data;
        
        print_r($req->polygon);
        // $data->polygon = DB::raw('GeomFromText(\'POLYGON('.$req->polygon.')\')');
        
       // $data->save();

       //return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = SpatialData::find($id);

        if (!$data) {
          return response()->json([
            'message' => 'Not found'
          ] ,404);
        }

        $data->status = 'x';
        $data->save();

        return response()->json($data, 200);
    }
}
