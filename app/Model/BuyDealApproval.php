<?php

namespace App\Model;

use App\Model\BuyDeal;

use Illuminate\Database\Eloquent\Model;

class BuyDealApproval extends Model
{
    protected $table = 'buy_deal_approval';

    public function BuyDeal() {
    	return $this->belongsTo('App\Model\BuyDeal');
    }
}
