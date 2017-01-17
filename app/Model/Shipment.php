<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    public function contracts() {
      return $this->hasOne(Contract::class);
    }

    public function suppliers() {
      return $this->hasOne(Company::class, 'supplier_id');
    }

    public function customers() {
      return $this->hasOne(Company::class, 'customer_id');
    }

    public function surveyors() {
      return $this->hasOne(Company::class, 'surveyor_id');
    }

    public function products() {
      return $this->hasOne(Product::class);
    }
}
