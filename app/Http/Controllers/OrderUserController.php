<?php

namespace App\Http\Controllers;

use App\Model\OrderUser;

use Illuminate\Http\Request;

use App\Http\Requests;

class OrderUserController extends Controller
{
	/*
	*	GET ALL OF USER ID RELATED TO A ORDER
	*
	*/
    public function findUserByOrder($order) {
    	$user_id = OrderUser::where('order_id', $order)->get();
    	
    	return response()->json($user_id, 200);
    }

	/*
	*	GET ALL OF ORDER ID RELATED TO A USER
	*
	*/
    public function findOrderByUser($user) {
    	$order_id = OrderUser::where('user_id', $user)->get();
    	
    	return response()->json($order_id, 200);
    }
}
