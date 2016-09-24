<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
	public $fillable = ['chat_id', 'user_id', 'message'];
	
    public function Chat() {
    	return $this->belongsTo('App\Model\Chat');
    }
}
