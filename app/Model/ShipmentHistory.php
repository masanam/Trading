<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShipmentHistory extends Model
{
  protected $table = 'shipment_history';

  public function shipments() {
    return $this->belongsTo(Shipment::class, 'shipment_id');
  }

  public function surveyors() {
    return $this->belongsTo(Company::class, 'surveyor_id');
  }
}
