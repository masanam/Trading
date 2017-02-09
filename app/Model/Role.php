<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {
	protected $table = 'roles';

    /*public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }*/

  public function privileges() {
    return $this->belongsToMany(Privilege::class);
	}

  public function users() {
    return $this->hasMany(User::class);
	}
}
