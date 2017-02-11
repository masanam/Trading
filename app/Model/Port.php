<?php

namespace App\Model;

use App\Model\Buyer;
use App\Model\Seller;

use Illuminate\Database\Eloquent\Model;

class Port extends Model {
  protected $table = 'ports';
  protected $fillable = [
    'port_name', 'owner', 'is_private', 'location', 'size',
    'river_capacity', 'latitude', 'longitude', 'anchorage_distance',
    'has_conveyor', 'has_crusher', 'has_blending', 'draft_height', 'daily_discharge_rate'
  ];

  /*public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }*/

  public function concessions() {
    return $this->hasMany(Concession::class);
  }

  public function factories() {
    return $this->hasMany(Factory::class);
  }

  public function companies() {
    return $this->belongsToMany(Company::class, 'company_port');
  }

}
