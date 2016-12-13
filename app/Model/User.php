<?php

namespace App\Model;

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

    public function Contact() {
        return $this->hasMany('Contact');
    }

    public function Buyer() {
        return $this->hasMany('Buyer');
    }

    public function Seller() {
        return $this->hasMany('Seller');
    }

    public function Activity() {
        return $this->hasMany('Activity');
    }

    public function LoginUser() {
        return $this->hasMany('LoginUser');
    }
    
    public function Deal() {
        return $this->hasMany('Deal');
    }

    public function BuyDeal() {
        return $this->hasMany('BuyDeal');
    }

    public function SellDeal() {
        return $this->hasMany('SellDeal');
    }

    public function BuyOrder() {
        return $this->hasMany('BuyOrder');
    }

    public function SellOrder() {
        return $this->hasMany('SellOrder');
    }

    public function directSubordinates() {
        return  $this->hasMany('App\Model\User', 'manager_id');
    }

    public function directManager() {
        return  $this->belongsTo('App\Model\User', 'manager_id');
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
}
