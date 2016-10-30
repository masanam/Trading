<?php

namespace App\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

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
}
