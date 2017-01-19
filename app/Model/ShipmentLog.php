<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShipmentLog extends Model
{
  protected $table = 'shipment_log';
  
  public function shipments() {
    return $this->belongsTo(Shipment::class, 'shipment_id');
  }

  public function users() {
    return $this->belongsTo(User::class, 'user_id');
  }
}
