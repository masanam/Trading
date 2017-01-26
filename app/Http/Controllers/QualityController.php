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
         */

        $quality = Shipment::with('contracts','customers','qualities')->get();
        return response()->json($quality, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $req)
    {
      $qualities = new QualityDetail();
      $qualities->quality_id = $req->quality_id;
      $qualities->value = $req->value;
      $qualities->quality = $req->quality;
      $qualities->save();
    }

    /*
     * hasapu 25-01-2017
     */

      public function show($id)
    {
      $quality = Shipment::with('contracts','customers','qualities')->find($id);
      return $quality;
    }

}
