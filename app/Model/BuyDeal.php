<?php

namespace App\Model;

use App\Model\BuyOrder;
use App\Model\BuyDealChat;
use App\Model\Deal;

use Illuminate\Database\Eloquent\Model;

class buy_deal extends Model
{
    protected $table = 'buy_deal';

    public function BuyOrder() {
    	return $this->belongsTo('BuyOrder');
    }

    public function BuyDealChat() {
    	return $this->hasMany('BuyDealChat');
    }

    public function deal() {
    	return $this->belongsTo('Deal');
    }
}
