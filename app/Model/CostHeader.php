<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class CostHeader extends Model
{
    public $timestamps = false;

    protected $table = 'cost_headers';

    public function miningLicense() {
    	return $this->belongsTo(MiningLicense::class,'mining_license_id')->select('*', DB::raw('ST_AsGeoJSON(polygon, 8) AS polygon'));
    }

  	public function calculationType() {
    	return $this->belongsTo(CalculationType::class,'calculation_id');
    }

    public function costDetail() {
    	return $this->hasMany(CostDetail::class,'header_id')->where('status','a');
    }

    public function costTotal() {
        return $this->hasOne(CostTotal::class,'header_id');
    }

    public function costDetailSum() {
        return $this->hasMany(CostDetail::class,'header_id')->select('*', DB::raw('SUM(base_value) as total_base_value'), DB::raw('SUM(deal_value) as total_deal_value'))->orderBy('section_id')->groupBy('header_id','section_id')->where('status','a');
    }

}
