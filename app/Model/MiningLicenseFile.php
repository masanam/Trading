<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class MiningLicenseFile extends Model {
	protected $table = 'mining_license_files';
	protected $fillable = [
        'id',
        'mining_licenses_id',
    	'url',
        'upload_by',
        'created_by',
        'updated_by'
    ];

    public function MiningLicense() {
        return $this->belongsTo('App\Model\MiningLicense');

    }
}

 /*
     * 
     * By AndezTea
     */
