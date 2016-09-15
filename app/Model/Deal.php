<?php

namespace App\Model;

use App\Model\BuyDeal;
use App\Model\SellDeal;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $table = 'deals';

    public function BuyDeal() {
    	return $this->hasMany('BuyDeal');
    }

    public function SellDeal() {
    	return $this->hasMany('SellDeal');
    }
}
