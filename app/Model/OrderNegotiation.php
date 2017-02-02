<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderNegotiation extends Model
{
    protected $table = 'order_negotiations';

    protected $fillable = [
    	'order_detail_id',
			'notes',
			'volume',
			'price',
			'user_id',
			'trading_term',
			'payment_term',
			'insurance_cost',
			'interest_cost',
			'surveyor_cost',
			'others_cost',
			'pit_to_port',
			'transhipment',
			'freight_cost',
			'port_to_factory'
    ];

    /*public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }*/
}
