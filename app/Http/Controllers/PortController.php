<?php

namespace App\Http\Controllers;

use App\Model\Port;
use App\Model\BuyerPort;
use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

class PortController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        $port = new Port();
        $port->port_name = $request->port_name;
        $port->owner = $request->owner;
        $port->is_private = $request->is_private;
        $port->location = $request->location;
        $port->size = $request->size;
        $port->river_capacity = $request->river_capacity;
        $port->latitude = $request->latitude;
        $port->longitude = $request->longitude;
        $port->anchorage_distance = $request->anchorage_distance;
        $port->has_conveyor = $request->has_conveyor;
        $port->has_crusher = $request->has_crusher;
        $port->has_blending = $request->has_blending;
        $port->draft_height = $request->draft_height;
        $port->save();

        return response()->json($port, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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

    public function buyerPort(Request $request)
    {
        if(!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        $buyer_port = new BuyerPort();
        $buyer_port->buyer_id = $request->buyer_id;
        $buyer_port->port_id = $request->port_id;
        $buyer_port->distance = $request->distance;
        $buyer_port->save();

        return response()->json($buyer_port, 200);
    }
}
