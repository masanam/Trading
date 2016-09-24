<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class MessageController extends Controller
{
    public function __construct () {
        $this->middleware('jwt.auth');
    }

    public function store(Request $request) {
    	$message = App\Model\Message::create([
    		'chat_id' => $request->chat_id,
    		'user_id' => $request->user_id,
    		'message' => $request->message,
    	]);

    	event(new MessageReceived($message));

    	return response()->json($message, 200);
    }
}
