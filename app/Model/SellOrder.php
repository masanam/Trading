<?php

namespace App\Model;

use App\Model\Seller;
use App\Model\SellDeal;
use App\Model\SellOrderPricing;

use Illuminate\Database\Eloquent\Model;

class SellOrder extends Model
{
    protected $table = 'sell_order';

    public function Seller() {
    	return $this->belongsTo('Seller');
    }

    public function SellDeal() {
    	return $this->hasMany('SellDeal');
    }

    public function SellOrderPricing() {
    	return $this->hasMany('SellOrderPricing');
    }
}
