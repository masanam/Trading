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
        // if($req->polygon) $data->polygon = DB::raw('GeomFromText(\'POLYGON('.$req->polygon.')\')');
        // dummy
        $data->polygon = DB::raw('GeomFromText(\'POLYGON((-0.167374767981244 117.14378841811163,-0.171898410089966 117.14378845149827,-0.171898424358005 117.14188494348036,-0.171898443617465 117.13929507144508,-0.171898648507238 117.10784138848203,-0.162851351720406 117.10784133906964,-0.162851301303192 117.11682810526895,-0.156610102905006 117.11682807233421,-0.155149722024873 117.11680740762836,-0.155129873592387 117.11682806361796,-0.147980395757486 117.11682802554833,-0.135709418874171 117.11682796204059,-0.135709384269774 117.12370311375514,-0.135709373498742 117.12581471432884,-0.129870772738343 117.12581468501901,-0.126662082238738 117.12581466914583,-0.126662077195135 117.12682575846316,-0.126662047438401 117.13271000548559,-0.126662036751384 117.13480141509069,-0.125071210476221 117.13480140708009,-0.117614748676942 117.13480137001909,-0.117614715693094 117.14138714790352,-0.11761470352576 117.14378810962046,-0.117614528179899 117.17083578256086,-0.1176142374498 117.2156818795313,-0.144755983501796 117.21568211189935,-0.144756225502533 117.18872195308052,-0.162850752765621 117.1887221119996,-0.162850835449433 117.17973537518094,-0.167374469512424 117.17973541580102,-0.167374521172007 117.173768913358,-0.167374767981244 117.14378841811163))\')');
        $data->status = 'a';
        $data->save();

        return $this->show($data->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = SpatialData::with('User')->select('*', DB::raw('ST_AsGeoJSON(polygon, 8) AS polygon'))->where('id',$id)->where('status', 'a')->first();

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
        if($req->polygon) $data->polygon = DB::raw('GeomFromText(\'POLYGON('.$req->polygon.')\')');
        $data->save();

        return $this->show($data->id);
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
