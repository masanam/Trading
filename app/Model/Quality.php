<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Quality extends Model
{
    protected $table = 'qualities';
    protected $fillable = [
      'shipment_id' ,'lead_id', 'status', 'type'
    ];

    public function qualityDetail() {
      return $this->belongsTo(QualityDetail::class, 'quality_id');
    }

    public function shipments() {
      return $this->belongsTo(Shipment::class);
    }

}
