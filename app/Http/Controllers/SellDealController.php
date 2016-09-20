<?php

namespace App\Http\Controllers;

use App\Model\SellDeal;

use Illuminate\Http\Request;

use App\Http\Requests;

class SellDealController extends Controller
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
        $sell_deal = SellDeal::where('status', 'a')->get();

        return response()->json($sell_deal, 200);
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

        $sell_deal = new SellDeal();
        $sell_deal->sell_order_id = $request->sell_order_id;
        $sell_deal->user_id = $request->user_id;
        $sell_deal->deal_id = $request->deal_id  ? $request->deal_id : NULL;
        $sell_deal->status = "a";
        $sell_deal->save();

        return response()->json($sell_deal, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SellDeal $sell_deal)
    {
        if($sell_deal->status == 'a') {
            return response()->json($sell_deal, 200);
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
    public function update(Request $request, SellDeal $sell_deal)
    {
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$sell_deal) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $sell_deal->sell_order_id = $request->sell_order_id;
        $sell_deal->user_id = $request->user_id;
        $sell_deal->deal_id = $request->deal_id  ? $request->deal_id : NULL;
        $buy_deal->status = "a";
        $sell_deal->save();

        return response()->json($sell_deal, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SellDeal $sell_deal)
    {
        if (!$sell_deal) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $sell_deal->status = 'x';
        $sell_deal->save();

        return response()->json($sell_deal, 200);
    }
}
