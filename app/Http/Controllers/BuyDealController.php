<?php

namespace App\Http\Controllers;

use App\Model\BuyDeal;

use Illuminate\Http\Request;

use App\Http\Requests;

class BuyDealController extends Controller
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
        $buy_deal = BuyDeal::where('status', 'a')
                        ->with(
                            'BuyOrder', 'BuyOrder.BuyOrderPricing', 'BuyOrder.Buyer',
                             'BuyOrder.Buyer.User', 'User', 'Deal'
                        )->get();

        return response()->json($buy_deal, 200);
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

        $buy_deal = new BuyDeal();
        $buy_deal->buy_order_id = $request->buy_order_id;
        $buy_deal->user_id = $request->user_id;
        $buy_deal->deal_id = $request->deal_id  ? $request->deal_id : NULL;
        $buy_deal->save();

        return response()->json($buy_deal, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BuyDeal $buy_deal)
    {
        if($buy_deal) {
            if($buy_deal->status == 'a') {
                return response()->json($buy_deal, 200);
            } else {
                return response()->json(['message' => 'deactivated record'], 404);
            }
        } else {
            return response()->json('Not found', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BuyDeal $buy_deal)
    {
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$buy_deal) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $buy_deal->buy_order_id = $request->buy_order_id;
        $buy_deal->user_id = $request->user_id;
        $buy_deal->deal_id = $request->deal_id  ? $request->deal_id : NULL;
        $buy_deal->save();

        return response()->json($buy_deal, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BuyDeal $buy_deal)
    {
        if (!$buy_deal) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $buy_deal->status = 'x';
        $buy_deal->save();

        return response()->json($buy_deal, 200);
    }
}
