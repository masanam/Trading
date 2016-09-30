<?php

namespace App\Http\Controllers;

use App\Model\Chat;
use App\Model\Message;
use App\Model\BuyOrder;

use Illuminate\Http\Request;

use App\Http\Requests;

class ChatController extends Controller
{
    public function __construct () {
        $this->middleware('jwt.auth');
    }

    /*
    Show all chat based on the user
    */
    public function index($user) {
        $chat = Chat::with('Message', 'BuyOrder.id')->where('trader_id', $user)->orWhere('approver_id', $user)->get();

        return response()->json(['success' => TRUE, $chat], 200);
    }

    public function show($buy_order) {
        $chat = Chat::with('Message', 'BuyOrder.id')->where('buy_order.id', $buy_order)->get();
    }

    public function store(Request $request) {
    	$chat = Chat::create([
    		'trader_id' => $request->trader_id,
    		'approver_id' => $request->approver_id,
    	]);

    	return response()->json(['success' => TRUE, $chat], 200);
    }
}
