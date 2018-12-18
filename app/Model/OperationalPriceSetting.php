<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OperationalPriceSetting extends Model
{
    public $timestamps = false;
	
    protected $table = 'operational_price';
    protected $fillable = [
      'id','name' ,'province', 'price', 'last_updated', 'date', 'status'
    ];
}
