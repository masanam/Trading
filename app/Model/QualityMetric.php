<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class QualityMetric extends Model
{
    protected $table = 'quality_metrics';
    protected $fillable = [
      'quality', 'metric'
    ];
}
