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

 public function mininglicenses() {
   return $this->hasMany(MiningLicense::class);
 }

}
