<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\BuyDeal;
use App\Model\SellDeal;
use App\Model\BuyOrder;
use App\Model\SellOrder;
use App\Model\User;

use App\Http\Requests;

class BuySellDealController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $buy_sell_deal = new \Illuminate\Database\Eloquent\Collection();

        $buy_deal = BuyDeal::where('status', 'a')
                            ->with([
                                'BuyOrder' => function ($query) {
                                    $query->select('order_date', 'volume');
                                },
                                'BuyOrder.Buyer' => function ($query) {
                                    $query->select('company_name');
                                },
                                'User' => function ($query) {
                                    $query->select('id', 'name', 'title');
                                },
                                'BuyOrder.BuyOrderPricing'
                            ])->get();

        foreach($buy_deal as $bd) {
            $buy_sell_deal->add($bd);
        }

        $sell_deal = SellDeal::where('status', 'a')
                            ->with([
                                'SellOrder' => function ($query) {
                                    $query->select('order_date', 'volume');
                                },
                                'SellOrder.Seller' => function ($query) {
                                    $query->select('company_name');
                                },
                                'User' => function ($query) {
                                    $query->select('id', 'name', 'title');
                                },
                                'SellOrder.SellOrderPricing'
                            ])->get();

        foreach($sell_deal as $sd) {
            $buy_sell_deal->add($sd);   
        }

        // $buy_sell_deal = $buy_sell_deal->sortBy('order_date');

        if($request->envelope) return response()->json([ 'order_deal' => $buy_sell_deal ], 200);
        return response()->json($buy_sell_deal, 200);
    }

    public function orderDealByUser($user_id) {
        $buy_sell_deal = new \Illuminate\Database\Eloquent\Collection();

        $buy_deal = BuyDeal::where([['status', 'a'], ['user_id', $user_id]])
                            ->with('BuyOrder','BuyOrder.Buyer','User','BuyOrder.BuyOrderPricing')->get();

        foreach($buy_deal as $bd) {
            $buy_sell_deal->add($bd);
        }

        $sell_deal = SellDeal::where([['status', 'a'], ['user_id', $user_id]])
                            ->with('SellOrder','SellOrder.Seller','User','SellOrder.SellOrderPricing')->get();

        foreach($sell_deal as $sd) {
            $buy_sell_deal->add($sd);   
        }

        // $buy_sell_deal = $buy_sell_deal->sortBy('order_date');

        return response()->json($buy_sell_deal, 200);
    }
}
