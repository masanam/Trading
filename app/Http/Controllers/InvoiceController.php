<?php

namespace App\Http\Controllers;

use App\Model\Invoice;
use App\Model\Shipment;
use App\Model\Quality;
use App\Model\QualityDetail;
use App\Model\QualityMetric;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $invoices = Invoice::with('shipments')->where('status', '!=', 'x')->get();
    //
    //     return response()->json($invoices, 200);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $invoice = new Invoice($request->all());
    //     $invoice->save();
    //     return response()->json($invoice, 200);
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $invoice = Invoice::with('shipments')->where('status', '!=', 'x')->find($id);
      if(!$invoice || $invoice->status != 'a') return response()->json(['message' => 'Not Found'], 404);
      $quality_details_price = [];
      $quality_details_tonnage = [];
      $quality_id = Quality::where('shipment_id',$id)->where('contract_id',$invoice->shipments->contract_id)->get();
      $i=0;
      $j=0;
      foreach ($invoice->price_calculation as $in) {
        foreach ($quality_id as $q_id) {
          $quality_detail = QualityDetail::with('quality','qualityMetric')->where('quality_metrics_id',$in['quality_metric_id'])->where('quality_id',$q_id->id)->first();
          if($quality_detail!==NULL) {
            $quality_detail->tier = $in['tier'];
            $quality_details_price[$i] = $quality_detail;
            $i++;
          }
        }
      }
      $i=0;
      $j=0;
      foreach ($invoice->tonnage_calculation as $in) {
        foreach ($quality_id as $q_id) {
          $quality_detail = QualityDetail::with('quality','qualityMetric')->where('quality_metrics_id',$in['quality_metric_id'])->where('quality_id',$q_id->id)->first();
          if($quality_detail!==NULL) {
            $quality_detail->tier = $in['tier'];
            $quality_details_tonnage[$i] = $quality_detail;
            $i++;
          }
        }
      }

      return response()->json(['detail_price' => $quality_details_price, 'detail_tonnage' => $quality_details_tonnage, 'invoice' => $invoice,'quality_id' =>$quality_id], 200);
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

      $invoice = Invoice::updateOrCreate(
        ['shipment_id' => $id],
        $request->all()
      );
      return response()->json($invoice, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $invoice = Invoice::find($id);
      $invoice->status = 'x';
      $invoice->save();
      return response()->json($invoice, 200);
    }

    public function tier(Request $req, $id)
    {
      $invoice = Invoice::find($id);
      if($invoice) {
        if($req->type==='price') $tier_array = $invoice->price_calculation;
        else if($req->type==='tonnage') $tier_array = $invoice->tonnage_calculation;
      }

      if($req->delete) {
        $i=0;
        $tier_a = [];
        foreach ($tier_array as $tier) {
          if($tier['tier']<$req->k) {
            $tier_a[$i] = $tier;
            $i++;
          }
          else if($tier['tier']>$req->k) {
            $tier['tier'] = $tier['tier']-1;
            $tier_a[$i] = $tier;
            $i++;
          }
        }
        if($req->type==='price') $invoice->price_calculation = $tier_a;
        else if($req->type==='tonnage') $invoice->tonnage_calculation = $tier_a;

      }

      if($req->s==='edit') {
        $i=0;
        $tier_a = [];
        foreach ($tier_array as $tier) {
          if($tier['tier']===(int)$req->k) {
            $tier['formula'] = $req->formula;
            $tier_a[$i] = $tier;
            $i++;
          } else {
            $tier_a[$i] = $tier;
            $i++;
          }
        }
        if($req->type==='price') $invoice->price_calculation = $tier_a;
        else if($req->type==='tonnage') $invoice->tonnage_calculation = $tier_a;
      }

      if($req->s==='create') {
        $metric = QualityMetric::get();
        foreach ($metric as $m) {
          if($m->quality===$req->k) {
            $quality_metric_id = $m->id;
          }
        }
        if($invoice) {
          $i=0;
          $tier_a = [];
          foreach ($tier_array as $tier) {
            $tier_a[$i] = $tier;
            $i++;
            $tier['tier'] = $tier['tier']+1;
            $tier['formula'] = $req->formula;
            $tier['quality_metric_id'] = $quality_metric_id;
            $tier_a[$i] = $tier;
          }
          if($req->type==='price') $invoice->price_calculation = $tier_a;
          else if($req->type==='tonnage') $invoice->tonnage_calculation = $tier_a;
        }
        else {
          $invoice = new Invoice();
          $invoice->shipment_id = $id;
          $invoice->status = 'a';
          $tier_a = [];
          $tier['tier'] = 1;
          $tier['formula'] = $req->formula;
          $tier['quality_metric_id'] = $quality_metric_id;
          $tier_a[0] = $tier;
          if($req->type==='price') $invoice->price_calculation = $tier_a;
          else if($req->type==='tonnage') $invoice->tonnage_calculation = $tier_a;
        }

      }


      $invoice->save();

      return response()->json($invoice, 200);
    }
}
