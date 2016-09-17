<?php

namespace App\Model;

use App\Model\Buyer;
use App\Model\BuyDeal;
use App\Model\BuyOrderPricing;

use Illuminate\Database\Eloquent\Model;

class BuyOrder extends Model
{
    protected $table = 'buy_order';

    public function buyer() {
    	return $this->belongsTo('Buyer');
    }

    public function BuyDeal() {
    	return $this->hasMany('BuyDeal');
    }

    public function BuyOrderPricing() {
    	return $this->hasMany('BuyOrderPricing');
    }
}
