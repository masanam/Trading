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
    public function index()
    {
        $buy_sell_deal = new \Illuminate\Database\Eloquent\Collection();

        $buy_deal = BuyDeal::where('status', 'a')
                            ->with(
                                'BuyOrder.order_date', 'BuyOrder.volume', 'BuyOrder.Buyer.company_name', 'BuyOrder.BuyOrderPricing', 'User.id', 'User.name', 'User.title'
                            )->get();

        foreach($buy_deal as $bd) {
            $buy_sell_deal->add($bd);
        }

        $sell_deal = SellDeal::where('status', 'a')
                            ->with(
                                'SellOrder.order_date', 'SellOrder.volume', 'SellOrder.Seller.company_name', 'SellOrder.SellOrderPricing', 'User.id', 'User.name', 'User.title'
                            )->get();

        foreach($sell_deal as $sd) {
            $buy_sell_deal->add($sd);   
        }

        $buy_sell_deal = $buy_sell_deal->sortBy('order_date');

        return response()->json($buy_sell_deal, 200);
    }
}
