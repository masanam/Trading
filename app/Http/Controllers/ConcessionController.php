<?php

namespace App\Http\Controllers;

use App\Model\Concession;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\DB;

class ConcessionController extends Controller
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
        $concession = Concession::where('status', 'a')->get();

        return response()->json($concession, 200);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search($search = false)
    {
        if (!$search) {
            $concession = Concession::where('status', 'a')->get();
        } else {
            $concession = Concession::where('status', 'a')->where('concession_name', 'LIKE', '%'.$search.'%')->get();
        }

        return response()->json($concession, 200);
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

        $concession = new Concession();
        $concession->concession_name = $request->concession_name;
        $concession->seller_id = $request->seller_id;
        $concession->owner = $request->owner;
        $concession->address = $request->address;
        $concession->city = $request->city;
        $concession->country = $request->country;
        $concession->latitude = $request->latitude;
        $concession->longitude = $request->longitude;
        $concession->polygon = $request->polygon;
        $concession->size = $request->size;
        $concession->stripping_ratio = $request->stripping_ratio;
        $concession->reserves = $request->reserves;
        $concession->contracted_volume = $request->contracted_volume;
        $concession->remaining_volume = $request->remaining_volume;
        $concession->annual_production = $request->annual_production;
        $concession->hauling_road_name = $request->hauling_road_name;
        $concession->road_accessibility = $request->road_accessibility;
        $concession->road_capacity = $request->road_capacity;
        $concession->stockpile_distance = $request->stockpile_distance;
        $concession->port_id = $request->port_id;
        $concession->port_distance = $request->port_distance;
        $concession->license_expiry_date = $request->license_expiry_date;
        $concession->license_type = $request->license_type;
        $concession->status = 'a';
        $concession->save();

        return response()->json($concession, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($concession)
    {
        $concession = Concession::find($concession);

        if($concession->status == 'a') {
            return response()->json($concession, 200);
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
    public function update(Request $request, $concession)
    {
        $concession = Concession::find($concession);

        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$concession) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $concession->concession_name = $request->concession_name;
        $concession->seller_id = $request->seller_id;
        $concession->owner = $request->owner;
        $concession->address = $request->address;
        $concession->city = $request->city;
        $concession->country = $request->country;
        $concession->latitude = $request->latitude;
        $concession->longitude = $request->longitude;
        $concession->polygon = $request->polygon;
        $concession->size = $request->size;
        $concession->stripping_ratio = $request->stripping_ratio;
        $concession->reserves = $request->reserves;
        $concession->contracted_volume = $request->contracted_volume;
        $concession->remaining_volume = $request->remaining_volume;
        $concession->annual_production = $request->annual_production;
        $concession->hauling_road_name = $request->hauling_road_name;
        $concession->road_accessibility = $request->road_accessibility;
        $concession->road_capacity = $request->road_capacity;
        $concession->stockpile_distance = $request->stockpile_distance;
        $concession->port_id = $request->port_id;
        $concession->port_distance = $request->port_distance;
        $concession->license_expiry_date = $request->license_expiry_date;
        $concession->license_type = $request->license_type;

        $concession->save();

        return response()->json($concession, 200);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $concession = Concession::find($id);
      
        if (!$id) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $concession = DB::table('concession')->where('id', $id)->update(['status' => 'x']);

        return response()->json($concession, 200);
    }



    public function getTotalConcession() {
        $total = Concession::count();
        $status = array('count' => $total);        
        return response()->json($status, 200);
    }
}
