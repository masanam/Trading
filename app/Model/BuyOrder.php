<?php

namespace App\Model;

use App\Model\Buyer;
use App\Model\BuyDeal;

use Illuminate\Database\Eloquent\Model;

class buy_order extends Model
{
    protected $table = 'buy_order';

    public function buyer() {
    	return $this->belongsTo('Buyer');
    }

    public function BuyDeal() {
    	return $this->hasMany('BuyDeal');
    }
}
