<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShipmentPlan extends Model
{
  protected $table = 'shipment_plans';

  public function contracts() {
    return $this->belongsTo(Contract::class, 'contract_id');
  }

  public function products() {
      return $this->belongsTo(ProductVariant::class, 'product_variant_id');
  }

  public function laycan_start() {
    return $this->belongsTo(ShipmentPlan::class, 'laycan_start');
  }

  public function laycan_end() {
    return $this->belongsTo(ShipmentPlan::class, 'laycan_end');
  }

  public function volume(){
    return $this->belongsTo(ShipmentPlan::class, 'volume');
  }

  public function status(){
    return $this->belongsTo(ShipmentPlan::class, 'status');
  }
}
