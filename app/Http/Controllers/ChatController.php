<?php

namespace App\Http\Controllers;

use App\Model\Chat;

use Illuminate\Http\Request;

use App\Http\Requests;

class ChatController extends Controller
{
    public function __construct () {
        $this->middleware('jwt.auth');
    }

    public function index($user) {
        $chat = Chat::with('Message')->where('trader_id', $user)->get();

        return response()->json($chat, 200);
    }

    public function store(Request $request) {
    	$chat = Chat::create([
    		'trader_id' => $request->trader_id,
    		'approver_id' => $request->approver_id,
    	]);

    	return response()->json($chat, 200);
    }
}
