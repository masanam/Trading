<?php

namespace App\Http\Controllers;

use App\Model\BuyOrder;
use App\Model\SellOrder;

use Illuminate\Http\Request;

use App\Http\Requests;

class BuySellOrderController extends Controller
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
        $buy_sell_order = new \Illuminate\Database\Eloquent\Collection();

        $buy_order = BuyOrder::where('status', 'a')
                            ->with(
                                'Buyer.company_name', 'BuyOrderPricing', 'User'
                            )->get();

        foreach($buy_order as $bo) {
            $bo['type'] = 'buy';
            $buy_sell_order->add($bo);
        }

        $sell_order = SellOrder::where('status', 'a')
                            ->with(
                                'Seller.company_name', 'SellOrderPricing', 'User'
                            )->get();

        foreach($sell_order as $so) {
            $so['type'] = 'sell';
            $buy_sell_order->add($so);   
        }

        $buy_sell_order = $buy_sell_order->sortBy('order_date');

        return response()->json(['success' => TRUE, $buy_sell_order], 200);
    }

    public function lastOrderByUser($type, $id) {
        if($type == 'buyer') {
            $buy_sell_order = BuyOrder::where('status', 'a')->where('', $id)
                            ->with(
                                'Buyer.company_name', 'BuyOrderPricing', 'User'
                            )->first();
        } else if($type == 'seller') {
            $buy_sell_order = SellOrder::where('status', 'a')->where('', $id)
                            ->with(
                                'Seller.company_name', 'SellOrderPricing', 'User'
                            )->first();
        }

        return response()->json(['success' => TRUE, $buy_sell_order], 200);
    }
}
