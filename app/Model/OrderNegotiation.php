<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderNegotiation extends Model
{
    protected $table = 'order_negotiations';

    protected $fillable = [
    	'order_detail_id',
    	'user_id',
		'volume',
		'base_currency_id',
		'base_price',
		'deal_currency_id',
		'deal_price',
		'exchange_rate',
		'trading_term',
		'payment_term',
		'notes'
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
