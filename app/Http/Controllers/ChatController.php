<?php

namespace App\Http\Controllers;

use App\Model\Chat;
use App\Model\Message;
use App\Model\BuyDeal;
use App\Model\SellDeal;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

use App\Http\Requests;

class ChatController extends Controller
{
    var $pusher;
    var $user;
    var $chatChannel;

    const DEFAULT_CHAT_CHANNEL = 'channel';

    public function __construct () {
        // $this->middleware('jwt.auth');
        $this->pusher = App::make('pusher');
        $this->user = Session::get('user');
        $this->chatChannel = self::DEFAULT_CHAT_CHANNEL;
    }

    /*
    Show all chat based on the user
    */
    public function showAllChatsByUser($user) {
        if($type == 'buy') {
            $chat = Chat::with('Message', 'BuyDeal.id')->where('trader_id', $user)->orWhere('approver_id', $user)->get();
        } else if($type == 'sell') {
            $chat = Chat::with('Message', 'SellDeal.id')->where('trader_id', $user)->orWhere('approver_id', $user)->get();
        }

        return response()->json($chat, 200);
    }

    public function showAllChatsByOrderDeal($type, $order_deal) {
        if($type == 'buy') {
            $chat = Chat::with('Message', 'BuyDeal')->where('order_deal_id', $order_deal)->get();
        } else if($type == 'sell') {
            $chat = Chat::with('Message', 'SellDeal')->where('order_deal_id', $order_deal)->get();
        }

        return response()->json($chat, 200);
    }

    public function showChat($type, $user, $order_deal, $chat_id) {
        if($type == 'buy') {
            $chat = Chat::with('Message', 'BuyDeal.id')->where([['order_deal_id', $order_deal], ['id', $chat_id]])->where('trader_id', $user)->orWhere('approver_id', $user)->get();
        } else if($type == 'sell') {
            $chat = Chat::with('Message', 'SellDeal.id')->where([['order_deal_id', $order_deal], ['id', $chat_id]])->where('trader_id', $user)->orWhere('approver_id', $user)->get();
        }

        return response()->json($chat, 200);
    }

    public function sendMessage(Request $request) {
        $message = Message::create([
            'chat_id' => $request->chat_id,
            'user_id' => $request->user_id,
            'message' => $request->message,
        ]);

        event(new \App\Events\MessageReceived($message));

        // $this->pusher->trigger($this->chatChannel, 'new-message', $message);
        return response()->json($message, 200);
    }

    public function storeChat(Request $request) {
    	$chat = Chat::create([
    		'trader_id' => $request->trader_id,
    		'approver_id' => $request->approver_id,
            'order_deal_id' => $request->order_deal_id,
            'type' => $request->type
    	]);

    	return response()->json($chat, 200);
    }
}
