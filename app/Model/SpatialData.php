<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SpatialData extends Model {
	protected $table = 'spatial_data';
	protected $fillable = ['name','restricted_area','type','desc'];

	public function User () {
        return $this->belongsTo('App\Model\User','created_by','id');
  }
}
