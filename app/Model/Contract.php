<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Order;

use DB;

class Contract extends Model
{
  // protected $dates = ['date_from', 'date_to', 'created_at', 'updated_at'];
  public function orders() {
    return $this->belongsTo(Order::class, 'order_id');
  }

  public function area() {
    return $this->belongsTo(Area::class);
  }

  public function shipments() {
    return $this->hasMany(Shipment::class);
  }

  public function qualities() {
    return $this->hasMany(Quality::class);
  }

  public function shipment_plans() {
    return $this->hasMany(ShipmentPlan::class);
  }

  public function companies() {
    return $this->belongsTo(Company::class, 'company_id');
  }

  public function products() {
    return $this->belongsTo(ProductVariant::class, 'product_id');
  }

  public function contract_calculations() {
    return $this->hasOne(ContractCalculation::class);
  }

  public function total_shipment_tonnage() {
    return $this->hasOne(Shipment::class)->selectRaw('contract_id, sum(volume) as volume')->groupBy('contract_id');
  }

}
