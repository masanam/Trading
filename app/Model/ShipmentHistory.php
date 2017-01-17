<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShipmentHistory extends Model
{
  protected $table = 'shipment_history';

  public function contracts() {
    return $this->belongsToMany(Contract::class);
  }

  public function surveyors() {
    return $this->belongsToMany(Company::class, 'surveyor_id');
  }
}
