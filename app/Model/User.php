<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'users';

    public function roles(){
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id');
    }

    public function getRoleAttribute($value) {
        $value = [];
        foreach($this->roles()->get() as $r) {
            $value[] = $r->role;
        }
        return $value;
    }

    // public function privileges(){
    //     return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id');
    // }

    // public function getPrivilegeAttribute($value) {
    //     $value = [];
    //     foreach($this->privileges()->get() as $r) {
    //         $value[] = $r->role;
    //     }
    //     return $value;
    // }

    public function contacts() {
        return $this->hasMany('Contact');
    }

    public function areas() {
        return $this->hasMany('Area');
    }

    public function shipment_log() {
      return $this->hasMany(ShipmentLog::class);
    }

    public function activities() {
        return $this->hasMany('Activity');
    }

    public function logins() {
        return $this->hasMany('LoginUser');
    }

    public function actings() { // who you're act for
        return $this->belongsToMany(User::class, 'acting_users', 'user_id', 'acting_as')
            ->where('acting_users.status', 'a')
            ->whereRaw('\'' . date('Y-m-d') . '\' BETWEEN date_start AND date_end')
            ->withPivot('role', 'date_start', 'date_end', 'status');
    }

    public function interims() { // who acted for you
        return $this->belongsToMany(User::class, 'acting_users', 'acting_as', 'user_id')
            ->where('acting_users.status', 'a')
            ->whereRaw('\'' . date('Y-m-d') . '\' BETWEEN date_start AND date_end')
            ->withPivot('role', 'date_start', 'date_end', 'status');
    }

    public function directSubordinates() {
        return  $this->hasMany('App\Model\User', 'manager_id');
    }

    public function directManager() {
        return  $this->belongsTo('App\Model\User', 'manager_id');
    }

    public function MiningLicenseHistories() {
        return  $this->hasMany('App\Model\MiningLicenseHistory');
    }

    public function subordinates($user = false)
    {
        if(!$user) $user = $this;
        $subs = collect([]);
        foreach ($user->directSubordinates as $sub ) {
            $subs->push($sub);
            $lower = $this->subordinates($sub);
            $subs = $subs->merge($lower);
        }
        return $subs;
    }

    public function managers($user = false)
    {
        if(!$user) $user = $this;
        $sups = collect([]);
        if($user->directManager){
            $sups->push($user->directManager);
            $upper = $this->managers($user->directManager);

            $sups = $sups->merge($upper);
        }
        return $sups;
    }

    public function isAdmin() {
        foreach ($this->roles() as $role) {
            if($role->role == 'admin') return true;
        }
        return false;
    }
}
