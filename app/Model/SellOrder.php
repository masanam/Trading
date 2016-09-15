<?php

namespace App\Model;

use App\Model\Seller;
use App\Model\SellDeal;

use Illuminate\Database\Eloquent\Model;

class SellOrder extends Model
{
    protected $table = 'sell_order';

    public function seller() {
    	return $this->belongsTo('Seller');
    }

    public function SellDeal() {
    	return $this->hasMany('SellDeal');
    }
}
