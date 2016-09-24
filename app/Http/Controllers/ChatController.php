<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ChatController extends Controller
{
    public function __construct () {
        $this->middleware('jwt.auth');
    }

    public function store(Request $request) {
    	$chat = App\Model\Chat::create([
    		'trader_id' => $request->trader_id,
    		'approver_id' => $request->approver_id,
    	]);

    	return response()->json($chat, 200);
    }
}
