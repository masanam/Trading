<?php

// Created By : Martin
// Tanggal : 27 Maret 2017

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductionPlan extends Model
{
    protected $table = 'production_plan';
    protected $fillable = [
      'product_id', 'month', 'year', 'tonnage','price'
    ];

    protected $primaryKey = 'product_id';
    public $incrementing = false;

    public function product_variant() {
        return $this->belongsTo(ProductVariant::class);
    }
}
