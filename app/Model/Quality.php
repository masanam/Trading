<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Quality extends Model
{
    protected $table = 'qualities';
    protected $fillable = [
      'shipment_id' , 'contract_id', 'status', 'type'
    ];

    public function qualityDetail() {
      return $this->hasMany(QualityDetail::class);
    }

    public function shipments() {
      return $this->belongsTo(Shipment::class, 'shipment_id');
    }

}
