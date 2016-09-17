<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\BuyDeal;
use App\Model\SellDeal;

use App\Http\Requests;

class BuySellDealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buy_deal = BuyDeal::where('status', 'a')->get();
        $sell_deal = SellDeal::where('status', 'a')->get();

        $buy_sell_deal = array_merge($buy_deal->toArray(), $sell_deal->toArray());

        return response()->json($buy_sell_deal, 200);
    }
}
