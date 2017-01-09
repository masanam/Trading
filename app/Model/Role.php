<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {
  protected $table = 'roles';

    public function permissions(){
        return $this->belongsToMany(Roles::class, 'permission_role', 'permission_id', 'role_id');
    }
}
