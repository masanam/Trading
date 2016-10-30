<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LoginUser extends Model
{
	protected $table = 'login_user';
	
    public function User() {
    	return $this->belongsTo('App\Model\User');
    }
}
