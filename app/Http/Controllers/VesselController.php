<?php

namespace App\Http\Controllers;

use App\Model\Shipment;
use App\Model\Vessel;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class VesselController extends Controller
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
        $vessel = Vessel::with('shipment')->where('status', 'a');

        if($req->q) {
          $param = $req->q;
          $vessel = $vessel->where('vessel_name', 'LIKE', '%'.$param.'%')
            ->orWhere('flag', 'LIKE', '%'.$req->q.'%')
            ->orWhere('build', 'LIKE', '%'.$req->q.'%')
            ->orWhere('deadweight_tonnage', 'LIKE', '%'.$req->q.'%')
            ->orWhere('length_overall', 'LIKE', '%'.$req->q.'%')
            ->orWhere('beam', 'LIKE', '%'.$req->q.'%')
            ->orWhere('containers', 'LIKE', '%'.$req->q.'%');
        }
       
        return response()->json($vessel->get(), 200);
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
        if(!$req) {
          return response()->json([
            'message' => 'Bad Request'
          ], 400);
        }

        $vessel = new Vessel();
        $vessel->vessel_name = $req->vessel_name;
        $vessel->flag = $req->flag;
        $vessel->build = $req->build;
        $vessel->deadweight_tonnage = $req->deadweight_tonnage;
        $vessel->length_overall = $req->length_overall;
        $vessel->beam = $req->beam;
        $vessel->containers = $req->containers;
        $vessel->flag = $req->flag;
        $vessel->status = 'a';
        $vessel->save();

        return response()->json($vessel, 200);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vessel  $vessel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vessel = Vessel::with('shipment')->find($id);
        return response()->json($vessel, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vessel  $vessel
     * @return \Illuminate\Http\Response
     */
    public function edit(Vessel $vessel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductVariant  $productVarint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $vessel)
    {
        $vessel = Vessel::find($vessel);

        if (!$req) return response()->json([ 'message' => 'Bad Request' ], 400);
        if (!$vessel) return response()->json([ 'message' => 'Not found' ] ,404);

        $vessel->vessel_name = $req->vessel_name;
        $vessel->flag = $req->flag;
        $vessel->build = $req->build;
        $vessel->deadweight_tonnage = $req->deadweight_tonnage;
        $vessel->length_overall = $req->length_overall;
        $vessel->beam = $req->beam;
        $vessel->containers = $req->containers;

        $vessel->save();

        return response()->json($vessel, 200);
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductVariant  $productVariant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vessel = Vessel::where('status', 'a')->find($id);

        if (!$vessel) return response()->json([ 'message' => 'Not found or Deactivated Vessel' ] ,404);

        $vessel->status = 'x';
        $vessel->save();

        return response()->json($vessel, 200);
    }
}
