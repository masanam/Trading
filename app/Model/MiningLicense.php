<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MiningLicense extends Model {
	protected $table = 'mining_licenses';
	protected $fillable = [
        'no',
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
		'received_at'
    ];

}
