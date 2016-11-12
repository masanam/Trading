<?php

namespace App\Model;

use App\Model\Seller;
use App\Model\SellDeal;
use App\Model\SellOrderPricing;

use Illuminate\Database\Eloquent\Model;

class SellOrder extends Model
{
    protected $table = 'sell_order';

    public function seller() {
    	return $this->belongsTo('App\Model\Seller');
    }

    public function SellOrderPricing() {
    	return $this->hasMany('App\Model\SellOrderPricing');
    }

    public function User() {
        return $this->belongsTo('App\Model\User');
    }

    public function Port() {
        return $this->hasOne('App\Model\Port', 'id', 'port_id');
    }

    public function Concession() {
        return $this->hasOne('App\Model\Concession', 'id', 'concession_id');
    }

    public function trader() {
        return $this->belongsTo('App\Model\User', 'user_id');
    }

    public function OrderDetail() {
        return $this->belongsTo('App\Model\OrderDetail', 'id', 'orderable_id')->where('orderable_type','App\Model\SellOrder');
    }
}
