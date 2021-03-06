<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class MiningLicense extends Model {
	protected $table = 'mining_licenses';
	protected $fillable = [
        'no',
        'province',
        'company_id',
    		'concession_id',
        'contact_id',
        'source',
        'type',
        'expired',
        'total_area',
        'overlap_other',
        'overlap_other_desc',
        'release_after',
        'release_after_desc',
        'already_production',
        'already_production_desc',

        'restricted_area',
        'description',
        'overlap_smg',
        'overlap_smg_desc',
        'produce_kp',
        'produce_kp_desc',
        'land_use',

        'location',

        'coal_bearing_formation',
        'geological_description',
        'geological_quality',
        'geological_cv',
        'geological_tm',
        'geological_ts',
        'geological_ash',
        'geological_reserve',
        'geological_stripping_ratio',
        'notes',

        'checked_by',
				'checked_at',
				'received_by',
				'received_at',

        'is_corrupt',
        'is_operating',
        'close_to_sinarmas_factory',
        'close_to_sinarmas_concession',
        'close_to_river',
        'close_to_other_concession',
        'is_mining_zone',
        'is_settlement_zone',
        'is_palm_plantation',
        'is_farming_zone',
        'is_sinarmas_forestry',
				'status',
    ];

    public function Company() {
        return $this->belongsTo('App\Model\Company');
    }

    public function Contact() {
        return $this->belongsTo('App\Model\Contact');
    }

    public function Concession() {
        return $this->belongsTo('App\Model\Concession')->select('*', DB::raw('ST_AsGeoJSON(polygon, 8) AS polygon'));
    }

    public function checked_by() {
        return $this->belongsTo('App\Model\User','checked_by','id');
    }

    public function MiningLicenseFile() {
        return $this->hasMany('App\Model\MiningLicenseFile')->where('status', 'a');
    }

    public function MiningLicenseHistory() {
        return $this->hasMany('App\Model\MiningLicenseHistory');
    }

    public function spatial_data(){
        return $this->belongsToMany(SpatialData::class,'mining_license_spatial_data','mining_license_id','spatial_data_id')->select('*', DB::raw('ST_AsGeoJSON(polygon, 8) AS polygon'));
    }

		/*
		 * hasapu 2017-01-27
		 */

	public function mininglicensehistories() {
        return $this->belongsTo(MiningLicenseHistory::class);
    }

    public function CostHeader() {
        return $this->hasOne(CostHeader::class);
    }

}
