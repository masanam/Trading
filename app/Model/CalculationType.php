<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CalculationType extends Model
{
    public $timestamps = false;
    protected $table = 'calculation_types';
    protected $fillable = [
        'cost_type'
    ];

    public function costSections() {
        return $this->hasMany(CostSection::class);
    }

    public function costHeader() {
        return $this->belongsTo(CostHeader::class);
    }

}
