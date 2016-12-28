<?php

namespace App\Http\Controllers;

use App\Model\Concession;
use App\Model\Seller;
use App\Model\Product;
use App\Model\Port;
use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Events\InputEditCoalpedia;

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
    public function index(Request $req)
    {
      if($req->company_id){
        if($req->coalpedia)
          $concession = Concession::where('status', 'a')->where('company_id', '!=', $req->company_id)->get();
        else
          $concession = Concession::where('status', 'a')->where('company_id', $req->company_id)->get();
        foreach ($concession as $con) {
          $con->latitude = floatval($con->latitude);
          $con->longitude = floatval($con->longitude);
          $con->stripping_ratio = floatval($con->stripping_ratio);
          $con->port_distance = floatval($con->port_distance);
        }
      } else if ($req->action == 'filter') {
        $concession = Concession::with(['company' => function($q) {
                            $q->where('companies.status', 'a');
                          }])
                          ->with(['port' => function($q) {
                            $q->where('ports.status', 'a');
                          }])
                          ->with(['products' => function($q) {
                            $q->where('products.status', 'a');
                          }]);

        if(isset($req['gt'])){
          foreach($req['gt'] as $input_gt){
            $gt_params = explode(",",$input_gt);
            $concession = $concession->whereHas('products' , function($q) use ($gt_params) {
                                        $q->where('products.'.$gt_params[0].'_min', '>=', $gt_params[1]);
                                      });
          }
        }
        if(isset($req['lt'])){
          foreach($req['lt'] as $input_lt){
            $lt_params = explode(",",$input_lt);
            $concession = $concession->whereHas('products' , function($q) use ($lt_params) {
                                        $q->where('products.'.$lt_params[0].'_max', '<=', $lt_params[1]);
                                      });
          }
        }
        if(isset($req['bet'])){
          foreach($req['bet'] as $input_bet){
            $bet_params = explode(",",$input_bet);
            $concession = $concession->whereHas('products' , function($q) use ($bet_params) {
                                        $q->where('products.'.$bet_params[0].'_min', '<=', $bet_params[1])
                                          ->where('products.'.$bet_params[0].'_max', '>=', $bet_params[1]);
                                      });
          }
        }
        if(isset($req['product'])) {
          $product_param = $req['product'];
          $concession = $concession->whereHas('products' , function($q) use ($product_param) {
                                  $q->where([['products.status', 'a'],['products.product_name', 'LIKE', '%'.$product_param.'%']]);
                                });
        }
        if(isset($req['concession'])) {
          $concession_param = $req['concession'];
          $concession = $concession->where('concession.concession_name', 'LIKE' , '%'.$concession_param.'%');
        }
        if(isset($req['seller'])) {
          $seller_param = $req['seller'];
          $concession = $concession->whereHas('company' , function($q) use ($seller_param) {
                                  $q->where([['companies.status', 'a'],['companies.company_name', 'LIKE' , '%'.$seller_param.'%']]);
                                });
        }
        if(isset($req['port'])) {
          $port_param = $req['port'];
          $concession = $concession->whereHas('port' , function($q) use ($port_param) {
                                  $q->where([['ports.port_name', 'LIKE' , '%'.$port_param.'%']]);
                                });
        }
        //var_dump($concession->toSql());
        $concession = $concession->where('concessions.status', 'a')->get();
      }else {
        $concession = Concession::with('company', 'products', 'port')->where('status', 'a')->limit(20);

        if($req->q) $concession->where('concession_name', 'LIKE', '%' . $req->q . '%');
        $concession = $concession->get();
      }

      return response()->json($concession, 200);
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

        $concession = new Concession($req->all());
        $concession->save();
      
        event(new InputEditCoalpedia(Auth::user(), $concession->id, 'concessions', 'create'));

        return response()->json($concession, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $concession = Concession::with('company', 'port', 'products')->find($id);

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

        $concession = Concession::with(['Product' => function($query)
        {
            $query->where('status', 'a');
        }, 'Port'])->find($id);

        /*$concession = Concession::with(['Product' => function($q){
            $q->where('status', 'a');
        }])->with('Port')->find($id);
        }])->with('Port')->whereHas('Product', function($q){
            $q->where('status', 'a');
        })->find($id);*/
        
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
        $concession->stockpile_capacity = $request->stockpile_capacity;
        $concession->stockpile_coverage = $request->stockpile_coverage;
        $concession->stockpile_distance = $request->stockpile_distance;
        $concession->port_id = $request->port_id;
        $concession->port_distance = $request->port_distance;
        $concession->license_expiry_date = date('Y-m-d',strtotime($request->license_expiry_date));
        $concession->license_type = $request->license_type;
        $concession->status = 'a';
        $concession->latitude = floatval($request->latitude);
        $concession->longitude = floatval($request->longitude);
        $concession->stripping_ratio = floatval($request->stripping_ratio);

        $concession->save();

        event(new InputEditCoalpedia(Auth::user(), $concession->id, 'concessions', 'update'));

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

    public function findMyConcession($id)
    {
        $concession = Concession::where('status', 'a')->where('seller_id', $id)->get();
        foreach ($concession as $con) {
          $con->latitude = floatval($con->latitude);
          $con->longitude = floatval($con->longitude);
          $con->stripping_ratio = floatval($con->stripping_ratio);
          $con->port_distance = floatval($con->port_distance);
        }

        return response()->json($concession, 200);
    }
}
