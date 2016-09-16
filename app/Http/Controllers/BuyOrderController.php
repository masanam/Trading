<?php

namespace App\Http\Controllers;

use App\Model\BuyOrder;

use Illuminate\Http\Request;

use App\Http\Requests;

class BuyOrderController extends Controller
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
        $BuyOrder = BuyOrder::where('status', 'a')->get();

        return response()->json($BuyOrder, 200);
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

        $BuyOrder = new BuyOrder();
        $BuyOrder->name = $request->name;
        $BuyOrder->image = $request->image;
        $BuyOrder->title = $request->title;
        $BuyOrder->email = $request->email;
        $BuyOrder->phone = $request->phone;
        $BuyOrder->save();

        return response()->json($BuyOrder, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BuyOrder $BuyOrder)
    {
        return response()->json($BuyOrder, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BuyOrder $BuyOrder)
    {
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$BuyOrder) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $BuyOrder->name = $request->name;
        $BuyOrder->image = $request->image;
        $BuyOrder->title = $request->title;
        $BuyOrder->email = $request->email;
        $BuyOrder->phone = $request->phone;

        $BuyOrder->save();

        return response()->json($BuyOrder, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BuyOrder $BuyOrder)
    {
        if (!$BuyOrder) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $BuyOrder->status = 'x';
        $BuyOrder->save();

        return response()->json($BuyOrder, 200);
    }
}
