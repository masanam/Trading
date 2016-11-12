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
    	return $this->belongsTo('App\Model\Buyer');
    }

    public function BuyOrderPricing() {
    	return $this->hasMany('App\Model\BuyOrderPricing');
    }

    public function User() {
        return $this->belongsTo('App\Model\User');
    }

    public function Port() {
        return $this->hasOne('App\Model\Port', 'id', 'port_id');
    }

    public function Factory() {
        return $this->hasOne('App\Model\Factory', 'id', 'factory_id');
    }

    public function trader() {
        return $this->belongsTo('App\Model\User', 'user_id');
    }

    public function OrderDetail() {
        return $this->belongsTo('App\Model\OrderDetail', 'id', 'orderable_id')->where('orderable_type','App\Model\BuyOrder');
    }
}
