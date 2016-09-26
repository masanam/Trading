<?php

namespace App\Model;

use App\Model\Deal;
use App\Model\Buyer;
use App\Model\Seller;
use App\Model\Contact;
use App\Model\Activity;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

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
    
    public function Deal() {
        return $this->hasMany('Deal');
    }
}
