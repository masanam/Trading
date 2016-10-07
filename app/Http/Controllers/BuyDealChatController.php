<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Model\BuyDealChat;
use App\Model\BuyDeal;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

use Vinkla\Pusher\Facades\Pusher;

class BuyDealChatController extends Controller
{
    var $user;

    public function __construct () {
        // $this->middleware('jwt.auth');
        $this->user = Session::get('user');
    }

    /*
    Show all chat based on the user
    */
    public function showAllBuyDealChatsByUser($user) {
        $chat = BuyDealChat::with('BuyDeal.id')->where('trader_id', $user)->orWhere('approver_id', $user)->get();

        return response()->json($chat, 200);
    }

    public function showAllBuyDealChatsByOrderDeal($buy_deal) {
        $chat = BuyDealChat::with('BuyDeal')->where('buy_deal_id', $buy_deal)->get();

        return response()->json($chat, 200);
    }

    public function sendChat(Request $request) {
        $chat = BuyDealChat::create([
        	'buy_deal_id' => $request->buy_deal_id,
            'user_id' => $request->user_id,
            'message' => $request->message,
        ]);


        Pusher::trigger('private-buy-deal-channel.'.$chat->buy_deal_id, 'new-message', $chat);
        return response()->json($chat, 200);
    }
}
