<?php

namespace App\Model;

use App\Model\SellDeal;

use Illuminate\Database\Eloquent\Model;

class SellDealChat extends Model
{
    protected $table = 'sell_deal_chat';

    public function SellDeal() {
    	return $this->belongsTo('SellDeal');
    }
}
