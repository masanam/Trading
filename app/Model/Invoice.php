<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
  protected $primaryKey = 'shipment_id';

  public $incrementing = false;

  protected $casts = [
    'price_calculation' => 'array',
    'tonnage_calculation' => 'array',
  ];

  public function shipments() {
    return $this->belongsTo(Shipment::class, 'shipment_id');
  }
}
