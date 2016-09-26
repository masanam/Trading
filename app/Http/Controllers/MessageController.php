<?php

namespace App\Http\Controllers;

use App\Model\Message;

use App\Events\MessageReceived;

use Illuminate\Http\Request;

use App\Http\Requests;

class MessageController extends Controller
{
    public function __construct () {
        $this->middleware('jwt.auth');
    }

    public function index($chat , $user) {
        $message = Message::where([
            ['chat_id', '=' , $chat],
            ['user_id', '=' , $user]
            ])->get();

        return response()->json($message, 200);
    }

    public function store(Request $request) {
    	$message = Message::create([
    		'chat_id' => $request->chat_id,
    		'user_id' => $request->user_id,
    		'message' => $request->message,
    	]);

    	event(new MessageReceived($message));

    	return response()->json($message, 200);
    }
}
