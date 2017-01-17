<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Order;

class Contract extends Model
{
  public function orders() {
    return $this->belongsTo(Order::class);
  }

  public function shipments() {
    return $this->belongsTo(Shipment::class);
  }
}
