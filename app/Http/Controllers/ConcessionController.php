<?php

namespace App\Http\Controllers;

use App\Model\Concession;
use App\Model\Seller;
use App\Model\Product;
use App\Model\Port;

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
    public function filter()
    {
        if (!$_GET) {
          var_dump('asdasd');
          $concession = Concession::with('Product', 'Seller', 'Port')->where('status', 'a')->get();
        } else {
            if(isset($_GET['gt'])){
              foreach($_GET['gt'] as $input_gt){
                $gt_params = explode(",",$input_gt);
                // $concession = DB::table('concession')
                //           ->select('concession.id', 'concession.latitude', 'concession.longitude', 'concession.polygon', 'products.*', 'sellers.*', 'ports.*')
                //           ->join('products', 'products.concession_id', '=', 'concession.id')
                //           ->leftJoin('sellers', 'concession.seller_id', '=', 'sellers.id')
                //           ->leftJoin('ports', 'concession.port_id', '=', 'ports.id')
                //           ->where('concession.status', 'a')
                //           ->where('products.status', 'a')
                //           ->where('products.'.$gt_params[0].'_min', '>=', $gt_params[1])
                //           ->get();

                $concession = Concession::with(['Product' => function($q) use ($gt_params) {
                                            $q->where('products.status', 'a')
                                              ->where('products.'.$gt_params[0].'_min', '>=', $gt_params[1]);
                                          }])
                                          ->with(['Seller' => function($q) {
                                            $q->where('sellers.status', 'a');
                                          }])
                                          ->with('Port')
                                          ->whereHas('Product', function($q) use ($gt_params) {
                                            $q->where('products.status', 'a')
                                              ->where('products.'.$gt_params[0].'_min', '>=', $gt_params[1]);
                                          })
                                          ->whereHas('Seller', function($q) {
                                            $q->where('sellers.status', 'a');
                                          })
                                          ->where('concession.status', 'a')
                                          ->get();
              }
            }
            if(isset($_GET['lt'])){
              foreach($_GET['lt'] as $input_lt){
                $lt_params = explode(",",$input_lt);
                // $concession = DB::table('concession')
                //           ->select('concession.id', 'concession.latitude', 'concession.longitude', 'concession.polygon', 'products.*', 'sellers.*', 'ports.*')
                //           ->join('products', 'products.concession_id', '=', 'concession.id')
                //           ->leftJoin('sellers', 'concession.seller_id', '=', 'sellers.id')
                //           ->leftJoin('ports', 'concession.port_id', '=', 'ports.id')
                //           ->where('concession.status', 'a')
                //           ->where('products.status', 'a')
                //           ->where('products.'.$lt_params[0].'_max', '<=', $lt_params[1])
                //           ->get();

                $concession = Concession::with(['Product' => function($q) use ($lt_params) {
                                            $q->where('products.status', 'a')
                                              ->where('products.'.$lt_params[0].'_max', '<=', $lt_params[1]);
                                          }])
                                          ->with(['Seller' => function($q) {
                                            $q->where('sellers.status', 'a');
                                          }])
                                          ->whereHas('Product' , function($q) use ($lt_params) {
                                            $q->where('products.status', 'a')
                                              ->where('products.'.$lt_params[0].'_max', '<=', $lt_params[1]);
                                          })
                                          ->whereHas('Seller' , function($q) {
                                            $q->where('sellers.status', 'a');
                                          })
                                          ->with('Port')
                                          ->where('concession.status', 'a')
                                          ->get();
              }
            }
            if(isset($_GET['bet'])){
              foreach($_GET['bet'] as $input_bet){
                $bet_params = explode(",",$input_bet);
                // $concession = DB::table('concession')
                //           ->select('concession.id', 'concession.latitude', 'concession.longitude', 'concession.polygon', 'products.*', 'sellers.*', 'ports.*')
                //           ->join('products', 'products.concession_id', '=', 'concession.id')
                //           ->leftJoin('sellers', 'concession.seller_id', '=', 'sellers.id')
                //           ->leftJoin('ports', 'concession.port_id', '=', 'ports.id')
                //           ->where('concession.status', 'a')
                //           ->where('products.status', 'a')
                //           ->where('products.'.$bet_params[0].'_min', '<=', $bet_params[1])
                //           ->where('products.'.$bet_params[0].'_max', '>=', $bet_params[1])
                //           ->get();

                $concession = Concession::with(['Product' => function($q) use ($bet_params) {
                                            $q->where('products.status', 'a')
                                              ->where('products.'.$bet_params[0].'_min', '<=', $bet_params[1])
                                              ->where('products.'.$bet_params[0].'_max', '>=', $bet_params[1]);
                                          }])
                                          ->with(['Seller' => function($q) {
                                            $q->where('sellers.status', 'a');
                                          }])
                                          ->with('Port')
                                          ->whereHas('Product' , function($q) use ($bet_params) {
                                            $q->where('products.status', 'a')
                                              ->where('products.'.$bet_params[0].'_min', '<=', $bet_params[1])
                                              ->where('products.'.$bet_params[0].'_max', '>=', $bet_params[1]);
                                          })
                                          ->whereHas('Seller' , function($q) {
                                            $q->where('sellers.status', 'a');
                                          })
                                          ->where('concession.status', 'a')
                                          ->get();
              }
            }
        }

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
        $concession->resource = $request->resource;
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id = "")
    {
        $concession = Concession::with(['Product' => function($q){
            $q->where('status', 'a');
        }])->whereHas('Product', function($q){
            $q->where('status', 'a');
        })->find($id);

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
        $concession->resource = $request->resource;
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
