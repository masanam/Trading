<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LoginUser extends Model
{
	protected $table = 'login_user';

    /*public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }*/

    public function User() {
    	return $this->belongsTo('App\Model\User');
    }
}
