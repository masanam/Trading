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

    public function orders() {
        return $this->morphToMany(Order::class, 'orderable', 'order_details')
            ->withPivot('id', 'price', 'volume', 'payment_term', 'trading_term');
    }

    public function reconcile() {
        $volume = $this->orders->sum('pivot.volume');
        if($this->volume >= $volume) $this->order_status = 's';
        else $this->order_status = 'p';
        $this->save();
    }    
}
