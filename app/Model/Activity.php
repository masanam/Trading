<?php

namespace App\Model;

use App\Model\User;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';

    public function user() {
    	return $this->belongsTo('User');
    }
}
