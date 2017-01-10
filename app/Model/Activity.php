<?php

namespace App\Model;

use App\Model\User;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';

    public function getCreatedAtAttribute($value)
    {
        return date('d.m.Y H:i:s', strtotime($value));
    }

    public function User() {
    	return $this->belongsTo('User');
    }
}
