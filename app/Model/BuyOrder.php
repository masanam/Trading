<?php

namespace App\Model;

use App\Model\Buyer;
use App\Model\BuyDeal;
use App\Model\BuyOrderPricing;

use Illuminate\Database\Eloquent\Model;

class BuyOrder extends Model
{
    protected $table = 'buy_order';

    public function Buyer() {
    	return $this->belongsTo('App\Model\Buyer');
    }

    public function BuyDeal() {
    	return $this->hasMany('App\Model\BuyDeal');
    }

    public function BuyOrderPricing() {
    	return $this->hasMany('App\Model\BuyOrderPricing');
    }

    public function User() {
        return $this->belongsTo('App\Model\User');
    }

    public function Port() {
        return $this->hasOne('App\Model\Port');
    }
}
