<?php

namespace App\Model;

use App\Model\BuyOrder;

use Illuminate\Database\Eloquent\Model;

class BuyOrderPricing extends Model
{
    protected $table = 'buy_order_pricing';

    public function BuyOrder() {
    	return $this->belongsTo('App\Model\BuyOrder');
    }
}
