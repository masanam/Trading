<?php

namespace App\Http\Controllers;

use App\Model\Concession;
use App\Model\Company;
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
      $concession = Concession::select('id','concession_name', 'company_id','owner', 'address', 'city', 'country', 'latitude', 'longitude', 'size', 'stripping_ratio', 'resource', 'reserves', 'contracted_volume', 'remaining_volume', 'annual_production', 'hauling_road_name', 'stockpile_capacity', 'stockpile_coverage', 'stockpile_distance', 'port_id', 'port_distance', 'license_type', 'license_expiry_date', 'status', 'created_at','updated_at',
		DB::raw('ST_AsGeoJSON(polygon, 8) AS polygon'));
	  
      if($req->company_id){
        if($req->coalpedia)
	      $concession = $concession->where('status', 'a')
			->where('company_id', '!=', $req->company_id)
			->get();
        else
          $concession->where('status', 'a')
			->where('company_id', $req->company_id)
			->get();
        foreach ($concession as $con) {
          $con->latitude = floatval($con->latitude);
          $con->longitude = floatval($con->longitude);
          $con->stripping_ratio = floatval($con->stripping_ratio);
          $con->port_distance = floatval($con->port_distance);
        }
      } else if ($req->action == 'filter') {
        $concession->with(['company' => function($q) {
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
            $concession->whereHas('products' , function($q) use ($gt_params) {
				$q->where('products.'.$gt_params[0].'_min', '>=', $gt_params[1]);
			});
          }
        }
        if(isset($req['lt'])){
          foreach($req['lt'] as $input_lt){
            $lt_params = explode(",",$input_lt);
            $concession->whereHas('products' , function($q) use ($lt_params) {
                                        $q->where('products.'.$lt_params[0].'_max', '<=', $lt_params[1]);
                                      });
          }
        }
        if(isset($req['bet'])){
          foreach($req['bet'] as $input_bet){
            $bet_params = explode(",",$input_bet);
            $concession->whereHas('products' , function($q) use ($bet_params) {
                                        $q->where('products.'.$bet_params[0].'_min', '<=', $bet_params[1])
                                          ->where('products.'.$bet_params[0].'_max', '>=', $bet_params[1]);
                                      });
          }
        }
        if(isset($req['product'])) {
          $product_param = $req['product'];
          $concession->whereHas('products' , function($q) use ($product_param) {
                                  $q->where([['products.status', 'a'],['products.product_name', 'LIKE', '%'.$product_param.'%']]);
                                });
        }
        if(isset($req['concession'])) {
          $concession_param = $req['concession'];
          $concession->where('concession.concession_name', 'LIKE' , '%'.$concession_param.'%');
        }
        if(isset($req['seller'])) {
          $seller_param = $req['seller'];
          $concession->whereHas('company' , function($q) use ($seller_param) {
                                  $q->where([['companies.status', 'a'],['companies.company_name', 'LIKE' , '%'.$seller_param.'%']]);
                                });
        }
        if(isset($req['port'])) {
          $port_param = $req['port'];
          $concession->whereHas('port' , function($q) use ($port_param) {
                                  $q->where([['ports.port_name', 'LIKE' , '%'.$port_param.'%']]);
                                });
        }
        if($req['country']) $concession->where('country',$req['country']);
        //var_dump($concession->toSql());
        $concession = $concession->where('concessions.status', 'a')->get();
      }else {
        $concession->with('company','products','port')->where('status', 'a')->limit(20);

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
        $concession->polygon = DB::raw('GeomFromText(\'POLYGON('.$concession->polygon.')\')');
        // dd($concession);
        $concession->status = 'a';
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
        $concession = Concession::select(
			'id',
      'concession_name',
			'owner',
			'address',
			'city',
			'country',
			'latitude',
			'longitude',
			DB::raw('ST_AsGeoJSON(polygon, 8) as polygon') ,
			'size',
			'stripping_ratio',
			'resource',
			'reserves',
			'contracted_volume',
			'remaining_volume',
			'annual_production',
			'hauling_road_name',
			'stockpile_capacity',
			'stockpile_coverage',
			'stockpile_distance',
			'port_id',
			'port_distance',
			'license_expiry_date',
			'license_type',
			'status',
			'latitude',
			'longitude',
			'stripping_ratio')
		  ->with('company', 'port', 'products')->find($id);

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
    public function update(Request $req, $concession)
    {
        $concession = Concession::find($concession);

        unset($concession->polygon);

        if (!$req) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$concession) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $concession->fill($req->except(['company_id', 'polygon', 'license_expiry_date', 'latitude', 'longitude']));

        if($req->polygon) $concession->polygon = DB::raw('GeomFromText(\'POLYGON('.$req->polygon.')\')');

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
        $concession = Concession::where('status', 'a')->where('company_id', $id)->get();
        foreach ($concession as $con) {
          $con->latitude = floatval($con->latitude);
          $con->longitude = floatval($con->longitude);
          $con->stripping_ratio = floatval($con->stripping_ratio);
          $con->port_distance = floatval($con->port_distance);
        }

        return response()->json($concession, 200);
    }
}
