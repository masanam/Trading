<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class QualityDetail extends Model
{
    // protected $table = 'quality_details';
    // protected $fillable = [
    //   'quality_id', 'value', 'quality'
    // ];

    public function quality() {
      return $this->hasMany(Quality::class);
    }
}
