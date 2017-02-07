<?php

/*
 * hasapu 2017-01-27
 * added mining license history table
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MiningLicenseHistory extends Model
{
 	protected $table = 'mining_license_history';
 	protected $fillable = [
        'id',
        'mining_license_id',
        'user_id',
    	'old_value',
        'new_value',
        'description',
        'created_at',
        'updated_at',
    ];

  	public function MiningLicense() {
        return $this->belongsTo('App\Model\MiningLicense');

  	}

  	public function User() {
        return $this->belongsTo('App\Model\User','user_id','id');
    }

}
