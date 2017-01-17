<?php

namespace App\Http\Controllers;

use App\Model\Shipment;

use Illuminate\Http\Request;

use App\Http\Requests;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shipments = Shipment::with('contracts', 'suppliers', 'customers', 'surveyors', 'products')->where('status', 'a')->get();

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
        $shipment = Shipment::find($id);

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

      return response()->json($shipment, 200);
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
