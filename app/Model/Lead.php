<?php

namespace App\Model;

use App\Model\Order;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $table = 'leads';

    public function Company() {
    	return $this->belongsTo('App\Model\Company');
    }

    public function User() {
        return $this->belongsTo('App\Model\User');
    }

    public function Port() {
        return $this->hasOne('App\Model\Port', 'id', 'port_id');
    }

    public function Concession() {
        return $this->hasOne('App\Model\concession', 'id', 'concession_id');
    }

    public function Factory() {
        return $this->hasOne('App\Model\Factory', 'id', 'factory_id');
    }

    public function Product() {
        return $this->hasOne('App\Model\Product', 'id', 'product_id');
    }

    public function trader() {
        return $this->belongsTo('App\Model\User', 'user_id');
    }

    public function orders() {
        return $this->belongsToMany(Order::class, 'order_details', 'leadable_id', 'id')
            ->withPivot('id', 'price', 'volume', 'payment_term', 'trading_term');
    }

    public function used() {
        return $this->belongsToMany(Order::class, 'order_details', 'leadable_id', 'id')
            ->selectRaw('sum(order_details.volume) as volume')->whereIn('orders.status', ['a', 'f', 'p', 'd'])->groupBy('leadable_id');
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

        if(isset($this->company)){
            $this->company->company_name = null;
            $this->company->latitude = null;
            $this->company->longitude = null;
            $this->company_id = null;
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

        if(isset($this->product)){
            $this->product->product_name = null;
            $this->product->company_id = null;
            $this->product->concession_id = null;
            $this->product_id = null;
            $this->product_name = null;
        }
    }

    public function difference($compare){
    	$diff = ['order_date_diff','order_expired_diff'];
    	$value = ['order_date','order_expired'];
		$this->gcv_adb_min_diff = abs($this->gcv_adb_min - $compare->gcv_adb_min);
		$this->gcv_adb_max_diff = abs($this->gcv_adb_max - $compare->gcv_adb_max);
		$this->gcv_arb_min_diff = abs($this->gcv_arb_min - $compare->gcv_arb_min);
		$this->gcv_arb_max_diff = abs($this->gcv_arb_max - $compare->gcv_arb_max);
		$this->ncv_min_diff = abs($this->ncv_min - $compare->ncv_min);
		$this->ncv_max_diff = abs($this->ncv_max - $compare->ncv_max);
		for ($i=0; $i < count($diff) ; $i++) {
			$this->$diff[$i] = floor((strtotime($this->$value[$i]) - strtotime($compare->$value[$i]))/3600/24);
		}
    }
}
