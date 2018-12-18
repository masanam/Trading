<?php

namespace App\Http\Controllers;

use App\Model\Quality;
use App\Model\QualityDetail;
use App\Model\QualityMetric;
use App\Model\Lead;
use App\Model\Contract;
use App\Model\Order;
use App\Model\Shipment;

use Illuminate\Http\Request;
use Auth;
use PDF;
use App\Http\Requests;

class QualityController extends Controller
{

    public function __construct()
    {
      $this->middleware('jwt.auth', [ 'except' => 'approval' ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $req)
    {
      /*
       * hasapu 25-01-2017
       * kamal 7-02-2017 if shipement_id
       */

      if($req->download == true){
        if($req->type == 'pdf')return $this->getPdf($req);
      }
      if($req->shipment_id) {
        $quality = Quality::with('qualityDetail','qualityDetail.qualityMetric')->where('shipment_id', $req->shipment_id);
        if($req->type) $quality = $quality->where('type',$req->type)->first();
        if($req->category == 'pre') $quality = $quality->where(function($q) {
          $q->where('type', 't')->orWhere('type', 'r')->orWhere('type', 'b');
        })->get();
        if($req->category == 'post') $quality = $quality->where(function($q) {
          $q->where('type', 't')->orWhere('type', 'r')->orWhere('type', 'b')->orWhere('type', 'a');
        })->get();
        $quality = $quality->first();
      }else if($req->contract_id) {
        $quality = Quality::with('qualityDetail','qualityDetail.qualityMetric')->where('contract_id', $req->contract_id);
        if($req->type) $quality = $quality->where('type',$req->type)->first();
        if($req->category == 'pre') $quality = $quality->where('type', 't')->orWhere('type', 'r')->orWhere('type', 'b')->get();
        if($req->category == 'post') $quality = $quality->where('type', 't')->orWhere('type', 'r')->orWhere('type', 'a')->get();
        $quality = $quality->first();
      }

      else $quality = Shipment::with('contracts','customer','qualities.qualityDetail.qualityMetric','contracts.orders.leads')->get();


      return response()->json($quality, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /*
     * kamal 7-02-2017 function below from store
     */
    public function store(Request $req)
    {
      if($req->invoice) {
        if($req->t) {
          $quality = new Quality();
          $quality->shipment_id = $req->shipment_id;
          $quality->contract_id = $req->contract_id;
          $quality->status = 'a';
          $quality->type = 't';
          $quality->save();
          $details = new QualityDetail();
          $details->quality_id = $quality->id;
          $details->value = $req->t;
          $details->quality_metrics_id = $req->q;
          $details->save();
        }
        if($req->a) {
          $quality = new Quality();
          $quality->shipment_id = $req->shipment_id;
          $quality->contract_id = $req->contract_id;
          $quality->status = 'a';
          $quality->type = 'a';
          $quality->save();
          $details = new QualityDetail();
          $details->quality_id = $quality->id;
          $details->value = $req->a;
          $details->quality_metrics_id = $req->q;
          $details->save();
        }
        if($req->r) {
          $quality = new Quality();
          $quality->shipment_id = $req->shipment_id;
          $quality->contract_id = $req->contract_id;
          $quality->status = 'a';
          $quality->type = 'r';
          $quality->save();
          $details = new QualityDetail();
          $details->quality_id = $quality->id;
          $details->value = $req->r;
          $details->quality_metrics_id = $req->q;
          $details->save();
        }


      }
      else {
        //check qualities for this shipment, if not available create new qualities
        $data = $this->checkAvailableQuality($req);

        // insert quality detail at that qualities
        $qualities = new QualityDetail();
        $qualities->quality_id = $data->id;
        $qualities->value = $req->quality['value'];
        $qualities->quality_metrics_id = $req->quality['quality_metrics_id'];
        $qualities->save();

        return response()->json(QualityDetail::with('qualityMetric')->find($qualities->id), 200);
      }


    }

    public function checkAvailableQuality(Request $req){
      if(isset($req->quality['shipment_id'])) $shipment_id = $req->quality['shipment_id'];
      else $shipment_id = null;
      if(!isset($req->quality['type'])) $type = null;
      else $type = $req->quality['type'];
      $data = Quality::where('shipment_id',$shipment_id)->where('status', 'a')->where('type',$req->quality['type'])->first();
      if (!$data) {
        $data = new Quality();
        $data->shipment_id = $req->quality['shipment_id'];
        $data->type = $req->quality['type'];
        $data->status = 'a';
        $data->save();
      }

      return $data;
    }

    /*
    * Aryo 26-03-2017
    */

    public function update(Request $request, $id) {
      foreach ($request->quality_detail as $qua) {
        if($qua['id']) {
          $quality = QualityDetail::where('id', $qua['id'])->where('quality_id', $id);
          if($qua['quality_metrics_id']) $quality = $quality->where('quality_metrics_id', $qua['quality_metrics_id']);
          $quality = $quality->first();
          $quality->value = $qua['value'];
        }
        else {
          $quality = new QualityDetail();
          $quality->quality_id = $id;
          $quality->value = $qua['value'];
          $quality->quality_metrics_id = $qua['quality_metrics_id'];
        }
        $quality->save();
      }

      $data = Quality::with('qualityDetail.qualityMetric')->find($id);

      return response()->json($data, 200);
    }

    /*
     * hasapu 25-01-2017
     */

      public function show($id)
    {
      // $quality = Shipment::with('contracts','customers','qualities')->find($id);

      // $data = Quality::where('id',$id)->where('status', 'a')->first();

      // if(!$data){
      //   $data = new Quality();
      //   $data->shipment_id = $req->shipment_id;
      //   $data->status = 'a';
      //   $data->save();
      // }

      // return response()->json($data, 200);

    }

    public function destroy($id)
    {
      $data = QualityDetail::find($id);

      if (!$data) {
        return response()->json([
          'message' => 'Not found'
        ] ,404);
      }

      $data->delete();

      return response()->json(true, 200);
    }

    public function getPdf($req){
      $quality = $this->retrieval($req, FALSE);

      $pdf = PDF::loadView('pdf.quality', [
        // 'shipments' => $shipments,
        'numActual' => '$numActual',
        'numForecast' => '$numForecast',
        'numFinished' => '$numFinished',
        'numCancelled' => '$numCancelled'
      ])->setPaper('a4', 'potrait');
      return $pdf->stream('quality.pdf');
    }

}
