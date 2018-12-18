<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ShippingInstruction;
use Auth;
use PDF;
use DB;


class ShippingInstructionController extends Controller
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
      if($req->type == 'pdf' && $req->shipping_instructions) return $this->getPdf($req);
      $si = ShippingInstruction::with('shipments','shipments.contracts');
      $si = $si->get();
      return response()->json($si,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function store(Request $req, $id)
    {
      $si = new ShippingInstruction($req->all());
      $si->shipment_id = $id;
      $si->status = 'd';

      $si->save();

      return response()->json($si,200);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $si = ShippingInstruction::with('shipments','shipments.contracts', 'shipments.vessel', 'shipments.customer', 'shipments.surveyors');
      $si = $si->find($id);
      return response()->json($si,200);
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
      $si = ShippingInstruction::find($id);
      if($si) {
        $si->fill($req->all());

        $si->save();

        return response()->json($si,200);
      } else {
        return $this->store($req, $id);
      }
    }

    public function getPdf($req){

      $si = ShippingInstruction::find($req->id);

      // $req->month = 'x';
      $pdf = PDF::loadView('pdf.shipping-instructions', [
        'si' => $si
      ])->setPaper('a4', 'portrait');

      return $pdf->stream('shipping-instructions.pdf');
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
