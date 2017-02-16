<?php

namespace App\Model;

use App\Model\Order;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $table = 'leads';
    protected $fillable = [
        'factory_id',
        'carrier_type',
        'concession_id',
    	'address',
        'city',
        'country',
        'latitude',
        'longitude',
        'port_distance',
        'port_id',
        'port_name',
        'port_status',
        'port_daily_rate',
        'port_draft_height',
        'port_latitude',
        'port_longitude',

        'product_name',
        'typical_quality',
        'product_id',

        'gcv_arb_min',
        'gcv_arb_max',
        'gcv_arb_reject',
        'gcv_arb_bonus',
        'gcv_adb_min',
        'gcv_adb_max',
        'gcv_adb_reject',
        'gcv_adb_bonus',
        'ncv_min',
        'ncv_max',
        'ncv_reject',
        'ncv_bonus',
        'ash_min',
        'ash_max',
        'ash_reject',
        'ash_bonus',
        'ts_min',
        'ts_max',
        'ts_reject',
        'ts_bonus',
        'tm_min',
        'tm_max',
        'tm_reject',
        'tm_bonus',
        'im_min',
        'im_max',
        'im_reject',
        'im_bonus',
        'fc_min',
        'fc_max',
        'fc_reject',
        'fc_bonus',
        'vm_min',
        'vm_max',
        'vm_reject',
        'vm_bonus',
        'hgi_min',
        'hgi_max',
        'hgi_reject',
        'hgi_bonus',
        'size_min',
        'size_max',
        'size_reject',
        'size_bonus',
        'fe2o3_min',
        'fe2o3_max',
        'fe2o3_reject',
        'fe2o3_bonus',
        'aft_min',
        'aft_max',
        'aft_reject',
        'aft_bonus',
        'na2o_min',
        'na2o_max',
        'na2o_reject',
        'na2o_bonus',

        'volume',
        'price',
        'currency',
        'trading_term',
        'trading_term_detail',
        'payment_term',
        'payment_term_detail',
        'commercial_term',
        'penalty',

        'progress_status',
    ];

    /*public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }*/

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
        return $this->hasOne('App\Model\Concession', 'id', 'concession_id');
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
        return $this->belongsToMany(Order::class, 'order_details', 'order_id', 'lead_id')
            ->withPivot('id', 'price', 'deal_currency_id', 'deal_price', 'volume', 'payment_term', 'trading_term');
    }

    public function ordersSpecific($status = 'd') {
        return $this->belongsToMany(Order::class, 'order_details', 'order_id', 'lead_id')
            ->where('status','!=',$status)
            ->withPivot('id', 'price', 'deal_currency_id', 'deal_price', 'volume', 'payment_term', 'trading_term');
    }

    public function countInOrders() {
        return $this->belongsToMany(Order::class, 'order_details', 'order_id', 'lead_id')
                    // ->where('lead_id', $id)
                    ->groupBy('order_details.lead_id')
                    // ->havingRaw('COUNT(order_details.order_id) < 2')
                    ->get();
    }

    public function used() {
        return $this->belongsToMany(Order::class, 'order_details')
            ->selectRaw('sum(order_details.volume) as volume')->whereIn('orders.status', ['a', 'f', 'p', 'd'])->groupBy('lead_id');
    }

    // reconcile the status and remaining volume of a leads
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
        $this->order_date_diff = floor((strtotime($this->order_date) - strtotime($compare->order_date))/3600/24);
        $this->order_expired_diff = floor((strtotime($this->order_expired) - strtotime($compare->order_expired))/3600/24);
    }
}
