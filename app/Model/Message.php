<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function Chat() {
    	return $this->belongsTo('App\Model\Chat');
    }
}
