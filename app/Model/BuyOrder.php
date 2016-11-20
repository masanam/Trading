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

    public function used() {
        return $this->morphToMany(Order::class, 'orderable', 'order_details')
            ->selectRaw('sum(order_details.volume) as volume')->whereIn('orders.status', ['a', 'f', 'p'])->groupBy('orderable_id', 'orderable_type');
    }

    public function reconcile() {
        $volume = $this->orders->sum('pivot.volume');
        if($this->volume >= $volume) $this->order_status = 's';
        else $this->order_status = 'p';
        $this->save();
    }

    public function cleanse() {
        $this->address = null;
        $this->latitude = null;
        $this->longitude = null;

        if(isset($this->buyer)){
            $this->buyer->company_name = null;
            $this->buyer->latitude = null;
            $this->buyer->longitude = null;
            $this->buyer_id = null;
        }

        if(isset($this->concession)){
            $this->concession->concession_name = null;
            $this->concession->seller_id = null;
            $this->concession->owner = null;
            $this->concession->latitude = null;
            $this->concession->longitude = null;
            $this->concession->polygon = null;
            $this->concession->port_id = null;
            $this->concession_id = null;
        }

        if(isset($this->port)){
            $this->port->port_name = null;
            $this->port->owner = null;
            $this->port->location = null;
            $this->port->latitude = null;
            $this->port->longitude = null;
            $this->port_id = null;
        }
    }
}
