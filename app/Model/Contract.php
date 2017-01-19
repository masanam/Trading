<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Order;

class Contract extends Model
{
  public function orders() {
    return $this->belongsTo(Order::class, 'order_id');
  }

  public function shipments() {
    return $this->hasMany(Shipment::class);
  }
}
