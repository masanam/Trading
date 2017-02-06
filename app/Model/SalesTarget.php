<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SalesTarget extends Model
{
    protected $table = 'sales_target';
    protected $fillable = [
      'product_id', 'month', 'year', 'value'
    ];

    protected $primaryKey = 'product_id';
    public $incrementing = false;

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
