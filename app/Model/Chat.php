<?php

namespace App\Model;

use App\Model\BuyDeal;
use App\Model\SellDeal;
use App\Model\Message;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    public function Message() {
    	return $this->hasMany('App\Model\Message');
    }
}
