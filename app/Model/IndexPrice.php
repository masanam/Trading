<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class IndexPrice extends Model
{

    protected $table = "index_price";
    protected $fillable = [
    	'date',
			'index_id',
    	'price',
			'day_of_year',
			'day_of_month',
			'day_of_week',
			'week',
			'month',
			'year',
			'is_autogenerated'
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
