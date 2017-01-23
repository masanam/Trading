<?php

namespace App\Http\Controllers;

use App\Model\Quality;
use App\Model\QualityDetail;
use App\Model\Lead;

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
        $quality = Quality::with('qualityDetail')->get();

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

}
