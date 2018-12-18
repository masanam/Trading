<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CostSection extends Model
{
    public $timestamps = false;
    
    protected $table = 'cost_sections';
    protected $fillable = [
        'section_name'
    ];

    public function costDetails() {
        return $this->hasMany(CostDetail::class);
    }

    public function calculationType() {
    	return $this->belongsTo(CalculationType::class);
  	}

}
