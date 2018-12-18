<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
	protected $table = 'product_variants';
    protected $fillable = [
      'id','product_id', 'name_product_variant', 'status'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function sales_target() {
        return $this->hasMany(SalesTarget::class);
    }
		
	public function production_plan() {
    return $this->hasMany(ProductionPlan::class);
    }

    public function shipment() {
        return $this->hasMany(Shipment::class);
    }

    public function shipmentPlan() {
        return $this->hasMany(Product::class);
    }
}
