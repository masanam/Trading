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
        $SellOrder = SellOrder::where('status', 'a')->get();

        return response()->json($SellOrder, 200);
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

        $SellOrder = new SellOrder();
        $SellOrder->name = $request->name;
        $SellOrder->image = $request->image;
        $SellOrder->title = $request->title;
        $SellOrder->email = $request->email;
        $SellOrder->phone = $request->phone;
        $SellOrder->save();

        return response()->json($SellOrder, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SellOrder $SellOrder)
    {
        if($SellOrder->status == 'a') {
            return response()->json($SellOrder, 200);
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
    public function update(Request $request, SellOrder $SellOrder)
    {
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$SellOrder) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $SellOrder->name = $request->name;
        $SellOrder->image = $request->image;
        $SellOrder->title = $request->title;
        $SellOrder->email = $request->email;
        $SellOrder->phone = $request->phone;

        $SellOrder->save();

        return response()->json($SellOrder, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SellOrder $SellOrder)
    {
        if (!$SellOrder) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $SellOrder->status = 'x';
        $SellOrder->save();

        return response()->json($SellOrder, 200);
    }
}
