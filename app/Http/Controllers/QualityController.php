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

use App\Http\Requests;

class QualityController extends Controller
{


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
      if($req->shipment_id) $quality = Quality::with('qualityDetail','qualityDetail.qualityMetric')->where('shipment_id', $req->shipment_id)->first();
      else $quality = Shipment::with('contracts','customers','qualities')->get();

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
      // check qualities for this shipment, if not available create new qualities
      $data = $this->checkAvailableQuality($req);

      // insert quality detail at that qualities
      $qualities = new QualityDetail();
      $qualities->quality_id = $data->id;
      $qualities->value = $req->quality['value'];
      $qualities->quality_metrics_id = $req->quality['quality_metrics_id'];
      $qualities->save();

      return response()->json(QualityDetail::with('qualityMetric')->find($qualities->id), 200);
    }

    public function checkAvailableQuality(Request $req){
      if(isset($req->quality['shipment_id'])) $shipment_id = $req->quality['shipment_id'];
      else $shipment_id = null;
      $data = Quality::where('shipment_id',$shipment_id)->where('status', 'a')->first();
      if (!$data) {
        $data = new Quality();
        $data->shipment_id = $req->quality['shipment_id'];
        $data->status = 'a';
        $data->save();
      }

      return $data;
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

}
