<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShippingInstruction extends Model
{
  protected $table = 'shipping_instructions';
  protected $primaryKey = 'shipment_id';
  public $incrementing = false;

  protected $fillable = [
    'shipment_id',
    'si_no',
    'si_date',
    'shipper_details',
    'consignee',
    'loading_port',
    'destination_port',
    'goods_desc',
    'qty',
    'qty_tolerence',
    'witness',
    'lc_no',
    'docs_berau',
    'docs_shipping',
    'docs_surveyor',
    'analysis_method',
    'sample_size',
    'sample_weight',
    'sample_address',
    'status'
  ];
  
  public function shipments() {
    return $this->belongsTo(Shipment::class, 'shipment_id');
  }
}
