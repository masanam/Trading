<?php

namespace App\Model;

use App\Model\Order;
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
