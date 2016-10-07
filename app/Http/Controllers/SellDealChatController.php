<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Model\SellDealChat;
use App\Model\SellDeal;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SellDealChatController extends Controller
{
    var $pusher;
    var $user;

    public function __construct () {
        // $this->middleware('jwt.auth');
        $this->pusher = App::make('pusher');
        $this->user = Session::get('user');
    }

    /*
    Show all chat based on the user
    */
    public function showAllSellDealChatsByUser($user) {
        $chat = SellDealChat::with('SellDeal.id')->where('trader_id', $user)->orWhere('approver_id', $user)->get();

        return response()->json($chat, 200);
    }

    public function showAllSellDealChatsByOrderDeal($sell_deal) {
        $chat = SellDealChat::with('SellDeal')->where('sell_deal_id', $sell_deal)->get();

        return response()->json($chat, 200);
    }

    public function sendChat(Request $request) {
        $chat = SellDealChat::create([
        	'sell_deal_id' => $request->sell_deal_id,
            'user_id' => $request->user_id,
            'message' => $request->message,
        ]);


        $this->pusher->trigger('sell-deal-channel.'.$chat->sell_deal_id, 'message-sent', $chat);
        return response()->json($chat, 200);
    }
}
