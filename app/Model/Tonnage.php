<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tonnage extends Model
{
    protected $table = 'sales_target';
    protected $fillable = [
      'product_id', 'month', 'year', 'value'
    ];

    public function product() {
        return $this->belongsTo('App\Model\Product');
    }

}
