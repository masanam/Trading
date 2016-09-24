<?php

namespace App\Model;

use App\Model\BuyDeal;
use App\Model\SellDeal;
use App\Model\User;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $table = 'deals';

    public function BuyDeal() {
    	return $this->hasMany('App\Model\BuyDeal');
    }

    public function SellDeal() {
    	return $this->hasMany('App\Model\SellDeal');
    }
    
    public function User() {
    	return $this->belongsTo('App\Model\User');
    }
}
