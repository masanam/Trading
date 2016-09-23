<?php

namespace App\Model;

use App\Model\SellDeal;

use Illuminate\Database\Eloquent\Model;

class SellDealApproval extends Model
{
    protected $table = 'sell_deal_approval';

    public function SellDeal() {
    	return $this->belongsTo('SellDeal');
    }
}
