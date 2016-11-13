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
			'user_id'
    ];
}
