<?php

namespace App\Http\Controllers;

use App\Model\Mine;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\DB;

class MineController extends Controller
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
        $mine = Mine::where('status', 'a')->get();

        return response()->json($mine, 200);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search($search = false)
    {
        if (!$search) {
            $mine = Mine::where('status', 'a')->get();
        } else {
            $mine = Mine::where('status', 'a')->where('mine_name', 'LIKE', '%'.$search.'%')->get();
        }

        return response()->json($mine, 200);
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

        $mine = new Mine();
        $mine->stripping_ratio = $request->stripping_ratio;
        $mine->mineable_reserve = $request->mineable_reserve;
        $mine->mine_name = $request->mine_name;
        $mine->latitude = $request->latitude;
        $mine->longitude = $request->longitude;
        $mine->road_accessibility = $request->road_accessibility;
        $mine->road_capacity = $request->road_capacity;
        $mine->river_capacity = $request->river_capacity;
        $mine->license_expired_date = $request->license_expired_date;
        $mine->license_type = $request->license_type;
        $mine->port_name = $request->port_name;
        $mine->port_distance = $request->port_distance;
        $mine->status = 'a';
        $mine->save();

        return response()->json($mine, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($mine)
    {
        $mine = Mine::find($mine);

        if($mine->status == 'a') {
            return response()->json($mine, 200);
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
    public function update(Request $request, $mine)
    {
        $mine = Mine::find($mine);

        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$mine) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $mine->stripping_ratio = $request->stripping_ratio;
        $mine->mineable_reserve = $request->mineable_reserve;
        $mine->mine_name = $request->mine_name;
        $mine->latitude = $request->latitude;
        $mine->longitude = $request->longitude;
        $mine->road_accessibility = $request->road_accessibility;
        $mine->road_capacity = $request->road_capacity;
        $mine->river_capacity = $request->river_capacity;
        $mine->license_expired_date = $request->license_expired_date;
        $mine->license_type = $request->license_type;
        $mine->port_distance = $request->port_distance;
        $mine->port_name = $request->port_name;

        $mine->save();

        return response()->json($mine, 200);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mine = Mine::find($id);
      
        if (!$id) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $mine = DB::table('mines')->where('id', $id)->update(['status' => 'x']);

        return response()->json($mine, 200);
    }



    public function getTotalMine() {
        $total = Mine::count();
        $status = array('count' => $total);        
        return response()->json($status, 200);
    }
}
