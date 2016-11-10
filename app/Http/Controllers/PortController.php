<?php

namespace App\Http\Controllers;

use App\Model\Port;
use App\Model\BuyerPort;
use App\Model\SellerPort;
use App\Model\Concession;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;

class PortController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $port = Port::where('is_private', '=', 0)->get();
        foreach ($port as $temp) {
            $temp->latitude = floatval($temp->latitude);
            $temp->longitude = floatval($temp->longitude);
        }
        return response()->json($port, 200);
    }

    public function buyerAllMyPort($buyer_id){
        $port =  Port::leftJoin('buyer_port', 'ports.id', '=', 'buyer_port.port_id')->select('buyer_port.*', 'ports.*')->where('buyer_port.buyer_id', '=', $buyer_id)->orwhere('buyer_port.buyer_id', '=', null)->orwhere('ports.is_private', '=', 0)->get();
        return response()->json($port, 200);
    }

    public function sellerAllMyPort($seller_id){
        $port =  Port::leftJoin('port_seller', 'ports.id', '=', 'port_seller.port_id')->where('port_seller.seller_id', '=', $seller_id)->orwhere('port_seller.seller_id', '=', null)->orwhere('ports.is_private', '=', 0)->get();
        return response()->json($port, 200);
    }

    public function buyerMyPort($buyer_id)
    {
        $port = BuyerPort::with('Port')->where('buyer_id', '=', $buyer_id)->where('status', '=', 'a')->get();
        return response()->json($port, 200);
    }

    public function sellerMyPort($seller_id)
    {
        $port = SellerPort::with('Port')->where('seller_id', '=', $seller_id)->where('status', '=', 'a')->get();
        return response()->json($port, 200);
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
        $port->daily_discharge_rate = $request->daily_discharge_rate;
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
        $port = Port::find($id);

        return response()->json($port, 200);
    }

    public function connectedConcessions($id) {
        $connectedConcessions = Concession::where('port_id', $id)->get();

        return response()->json($connectedConcessions, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $port)
    {
       $port = Port::find($port);

        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$port) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

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
        $port->daily_discharge_rate = $request->daily_discharge_rate;
        $port->save();

        return response()->json($port, 200);
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

    public function storeBuyerPort(Request $request)
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
        $buyer_port->status = 'a';
        $buyer_port->save();

        return response()->json($buyer_port, 200);
    }

    public function storeSellerPort(Request $request)
    {
        if(!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        $seller_port = new SellerPort();
        $seller_port->seller_id = $request->seller_id;
        $seller_port->port_id = $request->port_id;
        $seller_port->distance = $request->distance;
        $seller_port->status = 'a';
        $seller_port->save();

        return response()->json($seller_port, 200);
    }

    public function changePortStatusBuyer($buyer_id, $port_id, $status)
    {
        $buyer_port = BuyerPort::where('buyer_id', '=', $buyer_id)->where('port_id', '=', $port_id)->first();

        if (!$buyer_port) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        if ($status) {
          $buyer_port->status = $status;
          $buyer_port->save();
        }

        return response()->json($buyer_port, 200);
    }

    public function changePortStatusSeller($seller_id, $port_id, $status)
    {
        $seller_port = SellerPort::where('seller_id', '=', $seller_id)->where('port_id', '=', $port_id)->first();

        if (!$seller_port) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        if ($status) {
          $seller_port->status = $status;
          $seller_port->save();
        }

        return response()->json($seller_port, 200);
    }
}
