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
use Illuminate\Support\Facades\DB;

use App\Http\Requests;

class DealController extends Controller
{
    public function __construct() {
        // $this->middleware('jwt.auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status = 'a')
    {
        // $deal = DB::table('deals')
        //   ->select(
        //     DB::raw('
        //       deals.*,
        //       users.name as trader_name,
        //       concat(buyers.company_name, ",") as buyer_name,
        //       concat(sellers.company_name, ",") as seller_name,
        //       sum(buy_order.volume) as volume,
        //       sum(buy_order.volume*buy_order.max_price) as total_sales,
        //       sum(sell_order.volume*sell_order.max_price) as total_cogs
        //     ')
        //   )
        //   ->leftJoin('buy_deal', 'deals.id', '=', 'buy_deal.deal_id')
        //   ->leftJoin('buy_order', 'buy_order.id', '=', 'buy_deal.buy_order_id')
        //   ->leftJoin('buyers', 'buy_order.buyer_id', '=', 'buyers.id')
        //   //->leftJoin('buy_deal_approval', 'buy_deal.id', '=', 'buy_deal_approval.buy_deal_id')
        //   //->leftJoin('buy_order_pricing', 'buy_order.id', '=', 'buy_order_pricing.buy_order_id')
        //   ->leftJoin('sell_deal', 'deals.id', '=', 'sell_deal.deal_id')
        //   ->leftJoin('sell_order', 'sell_order.id', '=', 'sell_deal.sell_order_id')
        //   ->leftJoin('sellers', 'sell_order.seller_id', '=', 'sellers.id')
        //   //->leftJoin('sell_deal_approval', 'sell_deal.id', '=', 'sell_deal_approval.sell_deal_id')
        //   //->leftJoin('sell_order_pricing', 'sell_order.id', '=', 'sell_order_pricing.sell_order_id')
        //   ->leftJoin('users', 'users.id', '=', 'deals.user_id')
        //   ->where([['deals.status', $status],['buy_deal.status', '!=', 'x'], ['sell_deal.status', '!=', 'x']])
        //   ->groupBy(
        //     'deals.id', 
        //     'users.name', 
        //     'deals.user_id', 
        //     'deals.status', 
        //     'deals.created_at', 
        //     'deals.updated_at',
        //     'sellers.company_name',
        //     'buyers.company_name'
        //   )
        //   ->get();

        $deal = Deal::with('BuyDeal', 'BuyDeal.BuyOrder', 'BuyOrder.Buyer', 'BuyDeal.BuyDealApproval', 'BuyOrder.BuyOrderPricing', 'SellDeal', 'SellDeal.SellOrder', 'SellOrder.Seller', 'SellDeal.SellDealApproval', 'SellOrder.SellOrderPricing', 'User')
          ->select(
            DB::raw('
              deals.*,
              users.name as trader_name,
              concat(buyers.company_name, ",") as buyer_name,
              concat(sellers.company_name, ",") as seller_name,
              sum(buy_order.volume) as volume,
              sum(buy_order.volume*buy_order.max_price) as total_sales,
              sum(sell_order.volume*sell_order.max_price) as total_cogs
            ')
          )
          ->where([['deals.status', $status],['buy_deal.status', '!=', 'x'], ['sell_deal.status', '!=', 'x']])
          ->groupBy(
            'deals.id', 
            'users.name', 
            'deals.user_id', 
            'deals.status', 
            'deals.created_at', 
            'deals.updated_at',
            'sellers.company_name',
            'buyers.company_name'
          )->toSql();
        
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
        $deal->user_id = $request->user_id;
        $deal->status = 'a';
        $deal->save();

        return response()->json($deal, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $deal = DB::table('deals')->select(DB::raw('
              deals.*, users.name as trader_name, concat(buyers.company_name, ",") as buyer_name, concat(sellers.company_name, ",") as seller_name, sum(buy_order.volume) as volume, sum(buy_order.volume*buy_order.max_price) as total_sales, sum(sell_order.volume*sell_order.max_price) as total_cogs
            ')
          )
          ->leftJoin('buy_deal', 'deals.id', '=', 'buy_deal.deal_id')
          ->leftJoin('buy_order', 'buy_order.id', '=', 'buy_deal.buy_order_id')
          ->leftJoin('buyers', 'buy_order.buyer_id', '=', 'buyers.id')
          //->leftJoin('buy_deal_approval', 'buy_deal.id', '=', 'buy_deal_approval.buy_deal_id')
          //->leftJoin('buy_order_pricing', 'buy_order.id', '=', 'buy_order_pricing.buy_order_id')
          ->leftJoin('sell_deal', 'deals.id', '=', 'sell_deal.deal_id')
          ->leftJoin('sell_order', 'sell_order.id', '=', 'sell_deal.sell_order_id')
          ->leftJoin('sellers', 'sell_order.seller_id', '=', 'sellers.id')
          //->leftJoin('sell_deal_approval', 'sell_deal.id', '=', 'sell_deal_approval.sell_deal_id')
          //->leftJoin('sell_order_pricing', 'sell_order.id', '=', 'sell_order_pricing.sell_order_id')
          ->leftJoin('users', 'users.id', '=', 'deals.user_id')
          ->where([['deals.id', $id],['buy_deal.status', '!=', 'x'], ['sell_deal.status', '!=', 'x']])
          ->groupBy(
            'deals.id', 
            'users.name', 
            'deals.user_id', 
            'deals.status', 
            'deals.created_at', 
            'deals.updated_at',
            'sellers.company_name',
            'buyers.company_name'
          )
          ->first();

        //if($deal->status == 'a') {
            return response()->json($deal, 200);
        /*} else {
            return response()->json(['message' => 'deactivated record'], 404);
        }*/
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

        $deal->user_id = $request->user_id;
        $deal->save();

        return response()->json($deal, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     if (!$id) {
    //         return response()->json([
    //             'message' => 'Not found'
    //         ] ,404);
    //     }
        
    //     $deal = DB::table('deals')
    //     ->where('id', $id)  // find your user by their email
    //     ->limit(1)  // optional - to ensure only one record is updated.
    //     ->update(array('status' => 'x'));  // update the record in the DB. 

    //     /*$deal->status = 'x';
    //     $deal->save();*/

    //     return response()->json($deal, 200);
    // }
    
    /**
     * Mark as finished the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Deal $deal , $status)
    {
        if (!$deal) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        if ($status) {
          $deal->status = $status;
          $deal->save();
        }
        
        // $deal = DB::table('deals')
        // ->where('id', $id)  // find your user by their email
        // ->limit(1)  // optional - to ensure only one record is updated.
        // ->update(array('status' => 'f'));  // update the record in the DB. 

        return response()->json($deal, 200);
    }
}
