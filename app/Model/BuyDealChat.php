<?php

namespace App\Model;

use App\Model\BuyDeal;

use Illuminate\Database\Eloquent\Model;

class BuyDealChat extends Model
{
    protected $table = 'buy_deal_chat';

    public function BuyDeal() {
    	return $this->belongsTo('BuyDeal');
    }
}
