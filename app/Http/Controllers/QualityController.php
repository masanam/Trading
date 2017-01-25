<?php

namespace App\Http\Controllers;

use App\Model\Quality;
use App\Model\QualityDetail;
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
     public function index()
    {
        // $quality = Quality::with('qualityDetail','shipments')->get();
        // return response()->json($quality, 200);

        /*
         * hasapu 25-01-2017
         */

        $quality = Shipment::with('contracts','customers')->get();
        return response()->json($quality, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lead_id = $request->lead_id;
        $shipment_id = $request->shipment_id;
        $type = $request->type;

        $quality = Quality::where([
            'lead_id' => $lead_id,
            'shipment_id' => $shipment_id,
            'type' => $type
        ])->first();

        if(!$quality) $quality = new QualityDetails();

        $quality->fill($request->only([
            'value', 'quality'

        ]));

        $quality->save();
    }

    /*
     * hasapu 25-01-2017
     */

    public function show($id)
    {
      //$user = User::with('directSubordinates','directManager','roles')->find($user);
      $quality = Shipment::with('contracts','customers')->find($id);
      return $quality;
    }


}
