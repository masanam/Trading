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
      return $this->hasMany(QualityDetail::class);
    }

}
