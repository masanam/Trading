<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {
	protected $table = 'roles';

    public function getCreatedAtAttribute($value)
    {
        return date('d.m.Y H:i:s', strtotime($value));
    }

}
