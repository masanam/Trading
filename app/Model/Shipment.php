<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    public function contracts() {
      return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function suppliers() {
      return $this->belongsTo(Company::class, 'supplier_id');
    }

    public function customers() {
      return $this->belongsTo(Company::class, 'customer_id');
    }

    public function surveyors() {
      return $this->belongsTo(Company::class, 'surveyor_id');
    }

    public function products() {
      return $this->belongsTo(Product::class, 'product_id');
    }

    public function shipment_history() {
      return $this->hasMany(ShipmentHistory::class);
    }

    public function shipment_log() {
      return $this->hasMany(ShipmentLog::class);
    }
}
