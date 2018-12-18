<?php

namespace App\Http\Controllers;


use App\Model\ShipmentPlan;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use DB;
use DateTime;
use DateTimeZone;


class ShipmentPlanController extends Controller
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
      // return response()->json($req);
      $shipment_plan = ShipmentPlan::with('contracts','products','contracts.orders.sells.Company', 'contracts.companies')->where('status', '!=', 'x');
      if($req->q){
        $param = $req->q;
        $shipment_plan = $shipment_plan->where(function($query) use ($param){
          $query->whereHas('contracts', function($q) use ($param) {
              $q->whereRaw('`contract_no` LIKE "%'.$param.'%"');
            })
            ->orwhereHas('contracts.orders.sells.Company', function($q) use ($param) {
              $q->whereRaw('`company_name` LIKE "%'.$param.'%"');
            })
            ->orwhereHas('contracts.companies', function($q) use ($param) {
              $q->whereRaw('`company_name` LIKE "%'.$param.'%"');
            })
            ->orwhereHas('products', function($q) use ($param) {
              $q->whereRaw('`name_product_variant` LIKE "%'.$param.'%"');
            })
            // ->orwhereHas('surveyors', function($q) use ($param) {
            //   $q->whereRaw('`company_name` LIKE "%'.$param.'%"');
            // })
            // ->orwhereHas('vessels', function($q) use ($param) {
            //   $q->whereRaw('`vessel_name` LIKE "%'.$param.'%"');
            // })
            ->orWhereRaw('laycan_start LIKE "%'.$param.'%"')
            ->orWhereRaw('laycan_end LIKE "%'.$param.'%"')
            ->orWhereRaw('volume LIKE "%'.$param.'%"');
            // ->orWhereRaw('demurrage_rate LIKE "%'.$param.'%"')
            // ->orWhereRaw('loading_rate LIKE "%'.$param.'%"')
            // ->orWhereRaw('price LIKE "%'.$param.'%"')
            // ->orWhereRaw('shipment_no LIKE "%'.$param.'%"');
        });
      }

      if($req->area) {
        $shipment_plan->whereHas('contracts', function($q) use ($req) {
          $q->where('area_id', $req->area);
        });
        // return response()->json($shipments->get(), 200);
      }

      if($req->contract){
        $shipment_plan->whereHas('contracts',function($q) use ($req){
          $q->where('label',$req->contract);
        });
      }
      if($req->month_ld && $req->year_ld){
        $month = $req->month_ld;
        $year = $req->year_ld;
        $shipment_plan = $shipment_plan->where(function($q) use ($month) {
          $q->where(DB::raw('MONTH(laycan_start)'),'=',$month)->orWhere(DB::raw('MONTH(laycan_end)'),'=',$month);
        })->where(function($q) use ($year) {
          $q->where(DB::raw('YEAR(laycan_start)'),'=',$year)->orWhere(DB::raw('YEAR(laycan_end)'),'=',$year);
        });
      }


      $shipment_plan = $shipment_plan->get();
      return response()->json($shipment_plan,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
      // return response()->json($req);
      // dd($req);
      $shipment_plans = new ShipmentPlan();
      $shipment_plans->contract_id = $req->contract_id;
      $shipment_plans->product_variant_id = $req->product_variant_id;
      $shipment_plans->laycan_start = $req->laycan_start;
      $shipment_plans->laycan_end = $req->laycan_end;
      $shipment_plans->volume = $req->volume;
      $shipment_plans->status = 'a';

      $shipment_plans->save();
      return response()->json(ShipmentPlan::with('contracts','products','contracts.orders.sells.Company', 'contracts.companies')->find($shipment_plans->id),200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $req, $id)
    {
      $shipment_plan = ShipmentPlan::with('contracts','products')->where('status','a')->find($id);
      return response()->json($shipment_plan,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $shipment_plan = ShipmentPlan::with('contracts','products','contracts.orders.sells.Company', 'contracts.companies')->find($id);

        if(!$req) return response()->json([ 'message' => 'Bad Request' ], 400);
        if (!$shipment_plan) return response()->json([ 'message' => 'Not found' ] ,404);

        $shipment_plan->product_variant_id = $req->product_variant_id;
        $shipment_plan->volume = $req->volume;
        $shipment_plan->laycan_start = $req->laycan_start;
        $shipment_plan->laycan_end = $req->laycan_end;
        $shipment_plan->save();
        return response()->json($shipment_plan);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
