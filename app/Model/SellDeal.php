<?php

namespace App\Model;

use App\Model\SellOrder;
use App\Model\SellDealChat;
use App\Model\Deal;

use Illuminate\Database\Eloquent\Model;

class SellDeal extends Model
{
    protected $table = 'sell_deal';

    public function SellOrder() {
    	return $this->belongsTo('SellOrder');
    }

    public function SellDealChat() {
    	return $this->hasMany('SellDealChat');
    }

    public function deal() {
    	return $this->belongsTo('Deal');
    }
}
