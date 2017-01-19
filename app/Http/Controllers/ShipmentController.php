<?php

namespace App\Http\Controllers;

use App\Model\Shipment;
use App\Model\ShipmentHistory;

use Illuminate\Http\Request;

use App\Http\Requests;

use Carbon\Carbon;
use DB;

/*
* Aryo Pradipta Gema 17 January 2017 13.00
*
* Controller to handle Shipment and Shipment History
*/
class ShipmentController extends Controller
{
    public function __construct() {
      $this->middleware('jwt.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
    * Aryo Pradipta Gema 18 January 2017 12.05
    * This index will handle data retrieval based on request parameter given by the frontend
    *
    * params:
    * $req->range = string
    * (ex: 'dec-2016,feb-2017' -> 'december 2016 to february 2017' , 'nov-2015,may-2017' -> 'november 2015 to may 2017')
    **/
    public function index(Request $req)
    {
      $range = [];
      $shipments = Shipment::with('contracts', 'contracts.orders', 'contracts.orders.sells', 'suppliers', 'customers', 'surveyors', 'products')->where('status', 'a');


      if($req->scheduled) {
        if($req->range) {
          $range = explode(',', $req->range);
          $from = explode('-', $range[0]);
          $till = explode('-', $range[1]);
          $monthFrom = $from[0]; $yearFrom = $from[1];
          $monthTill = $till[0]; $yearTill = $till[1];
          $fromDate = new Carbon('first day of ' . $monthFrom . ' ' . $yearFrom);
          $tillDate = new Carbon('last day of ' . $monthTill . ' ' . $yearTill);
          $shipments = $shipments->whereBetween(DB::raw('date(laycan_start)'), [$fromDate, $tillDate])
            ->orWhereBetween(DB::raw('date(laycan_end)'), [$fromDate, $tillDate]);
        }
        else
          $shipments = $shipments
            ->where( DB::raw('MONTH(laycan_start)'), '=', date('n') )
            ->orWhere( DB::raw('MONTH(laycan_end)'), '=', date('n') );


      }

      $shipments = $shipments->get();

      return response()->json($shipments, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $shipment = new Shipment();

        $shipment->contract_id = $request->contract_id;
        $shipment->supplier_id = $request->supplier_id;
        $shipment->customer_id = $request->customer_id;
        $shipment->product_id = $request->product_id;
        $shipment->surveyor_id = $request->surveyor_id;
        $shipment->shipment_no = $request->shipment_no;
        $shipment->vessel = $request->vessel;
        $shipment->laycan_start = $request->laycan_start;
        $shipment->laycan_end = $request->laycan_end;
        $shipment->eta = $request->eta;
        $shipment->etd = $request->etd;
        $shipment->volume = $request->volume;
        $shipment->demurrage_rate = $request->demurrage_rate;
        $shipment->loading_rate = $request->loading_rate;
        $shipment->price = $request->price;
        $shipment->status = 'a';

        $shipment->save();

        $shipment_history = $this->storeShipmentHistory($shipment);

        return response()->json($shipment, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shipment = Shipment::with('contracts', 'contracts.orders', 'contracts.orders.sells', 'suppliers', 'customers', 'surveyors', 'products')->where('status', 'a')->find($id);

        return response()->json($shipment, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $shipment = Shipment::find($id);

      $shipment->contract_id = $request->contract_id;
      $shipment->supplier_id = $request->supplier_id;
      $shipment->customer_id = $request->customer_id;
      $shipment->product_id = $request->product_id;
      $shipment->surveyor_id = $request->surveyor_id;
      $shipment->shipment_no = $request->shipment_no;
      $shipment->vessel = $request->vessel;
      $shipment->laycan_start = $request->laycan_start;
      $shipment->laycan_end = $request->laycan_end;
      $shipment->eta = $request->eta;
      $shipment->etd = $request->etd;
      $shipment->volume = $request->volume;
      $shipment->demurrage_rate = $request->demurrage_rate;
      $shipment->loading_rate = $request->loading_rate;
      $shipment->price = $request->price;
      $shipment->status = $request->status ? $request->status : $shipment->status;

      $shipment->save();

      $shipment_history = $this->storeShipmentHistory($shipment);

      return response()->json($shipment, 200);
    }

    private function storeShipmentHistory($shipment) {
      $shipment_history = new ShipmentHistory();
      $shipment_history->shipment_id = $shipment->id;
      $shipment_history->surveyor_id = $shipment->surveyor_id;
      $shipment_history->vessel = $shipment->vessel;
      $shipment_history->laycan_start = $shipment->laycan_start;
      $shipment_history->laycan_end = $shipment->laycan_end;
      $shipment_history->eta = $shipment->eta;
      $shipment_history->etd = $shipment->etd;
      $shipment_history->volume = $shipment->volume;
      $shipment_history->demurrage_rate = $shipment->demurrage_rate;
      $shipment_history->loading_rate = $shipment->loading_rate;
      $shipment_history->price = $shipment->price;
      $shipment_history->status = 'a';
      $shipment_history->save();

      return $shipment_history;
    }

    public function indexShipmentHistory() {
      $shipment_histories = ShipmentHistory::with('shipments', 'shipments.contracts', 'shipments.suppliers', 'shipments.customers', 'surveyors', 'shipments.products')->where('status', 'a')->get();
      return response()->json($shipment_histories, 200);
    }

    public function showShipmentHistory($id) {
      $shipment_history = ShipmentHistory::with('shipments', 'shipments.contracts', 'shipments.suppliers', 'shipments.customers', 'surveyors', 'shipments.products')->where('status', 'a')->find($id);

      return response()->json($shipment_history, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $shipment = Shipment::find($id);

      $shipment->status = 'x';

      $shipment->save();

      return response()->json($shipment, 200);
    }
}
