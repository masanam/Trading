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

    protected $appends = ['privilege', 'role'];

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

    public function getPrivilegeAttribute($value) {
        $value = [];
        foreach($this->roles()->get() as $r) {
            foreach($r->privileges()->get() as $p){
                $value[] = $p->menu;    
            }
        }
        return array_unique($value);
    }

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
        return $this->hasOne('App\Model\LoginUser');
    }

    //For Documents - By Myrtyl - 06/02/2017
    public function documents(){
      return $this->hasMany(Document::class);
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

    public function leads() {
        return  $this->hasMany('App\Model\Lead');
    }
    public function orders() {
        return  $this->hasMany('App\Model\Order');
    }
    public function companies() {
        return  $this->hasMany('App\Model\Company');
    }
    public function products() {
        return  $this->hasMany('App\Model\Product');
    }
}
