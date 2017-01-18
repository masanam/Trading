<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TonnageHistory extends Model
{
    protected $table = 'tonnages_history';
    protected $fillable = [
      'updated_by','product_id', 'month', 'year', 'value'
    ];

    public function product() {
        return $this->belongsTo('App\Model\Product');
    }

}
