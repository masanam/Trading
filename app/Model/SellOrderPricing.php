<?php

namespace App\Model;

use App\Model\SellOrder;

use Illuminate\Database\Eloquent\Model;

class SellOrderPricing extends Model
{
    protected $table = 'sell_order_pricing';

    public function SellOrder() {
    	return $this->belongsTo('SellOrder');
    }
}