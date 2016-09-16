<?php

namespace App\Http\Controllers;

use App\Model\SellOrder;

use Illuminate\Http\Request;

use App\Http\Requests;

class SellOrderController extends Controller
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
        $sell_order = SellOrder::where('status', 'a')->get();

        return response()->json($sell_order, 200);
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

        $sell_order = new SellOrder();
        $sell_order->name = $request->name;
        $sell_order->image = $request->image;
        $sell_order->title = $request->title;
        $sell_order->email = $request->email;
        $sell_order->phone = $request->phone;
        $sell_order->save();

        return response()->json($sell_order, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SellOrder $sell_order)
    {
        if($sell_order->status == 'a') {
            return response()->json($sell_order, 200);
        } else {
            return response()->json(['message' => 'deactivated record'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SellOrder $sell_order)
    {
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$sell_order) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $sell_order->name = $request->name;
        $sell_order->image = $request->image;
        $sell_order->title = $request->title;
        $sell_order->email = $request->email;
        $sell_order->phone = $request->phone;

        $sell_order->save();

        return response()->json($sell_order, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SellOrder $sell_order)
    {
        if (!$sell_order) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $sell_order->status = 'x';
        $sell_order->save();

        return response()->json($sell_order, 200);
    }
}
