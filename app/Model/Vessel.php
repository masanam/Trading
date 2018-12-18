<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Vessel extends Model
{
    protected $table = 'vessels';
    protected $fillable = [
      'id','vessel_name', 'flag', 'build', 'deadweight_tonnage', 'length_overall', 'beam', 'containers', 'status'
    ];

    public function shipment() {
        return $this->hasMany(Shipment::class);
    }
}
