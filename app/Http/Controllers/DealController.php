<?php

namespace App\Http\Controllers;

use App\Model\Deal;
use App\Model\BuyDeal;
use App\Model\BuyOrder;
use App\Model\BuyOrderPricing;
use App\Model\BuyDealApproval;
use App\Model\SellDeal;
use App\Model\SellOrder;
use App\Model\SellOrderPricing;
use App\Model\SellDealApproval;

use Illuminate\Http\Request;

use App\Http\Requests;

class DealController extends Controller
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
        $deal = Deal::with('BuyDeal', 'BuyDeal.BuyOrder', 'BuyDeal.BuyOrder.BuyOrderPricing', 'BuyDeal.BuyDealApproval', 'SellDeal', 'SellDeal.SellOrder', 'SellDeal.SellOrder.SellOrderPricing', 'SellDeal.SellDealApproval')->where('status', 'a')->get();

        return response()->json($deal, 200);
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

        $deal = new Deal();
        $deal->save();

        return response()->json($deal, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($deal)
    {
        $deal = Deal::with('BuyDeal', 'BuyDeal.BuyOrder', 'BuyDeal.BuyOrder.BuyOrderPricing', 'BuyDeal.BuyDealApproval', 'SellDeal', 'SellDeal.SellOrder', 'SellDeal.SellOrder.SellOrderPricing', 'SellDeal.SellDealApproval');

        if($deal->status == 'a') {
            return response()->json($deal, 200);
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
    public function update(Request $request, Deal $deal)
    {
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$deal) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        // $deal->save();

        return response()->json($deal, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deal $deal)
    {
        if (!$deal) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $deal->status = 'x';
        $deal->save();

        return response()->json($deal, 200);
    }
}
