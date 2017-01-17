<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SpatialData extends Model {
	protected $table = 'spatial_data';
	protected $fillable = ['restricted_area','type','desc'];
}
