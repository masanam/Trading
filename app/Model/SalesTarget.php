<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SalesTarget extends Model
{
    protected $table = 'sales_target';
    protected $fillable = [
      'product_id', 'month', 'year', 'tonnage','price'
    ];

    protected $primaryKey = 'product_id';
    public $incrementing = false;

    public function product_variant() {
        return $this->belongsTo(ProductVariant::class);
    }
}
