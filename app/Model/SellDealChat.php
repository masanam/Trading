<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SellDealChat extends Model
{
	protected $table = 'sell_deal_chat';
	protected $fillable = ['sell_deal_id', 'user_id', 'message'];

    public function SellDeal() {
    	return $this->belongsTo('App\Model\SellDeal');
    }
}
