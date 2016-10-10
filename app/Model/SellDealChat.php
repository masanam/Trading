<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Mpociot\Firebase\SyncsWithFirebase;

class SellDealChat extends Model
{
	use SyncsWithFirebase;

	protected $table = 'sell_deal_chat';
	protected $fillable = ['sell_deal_id', 'user_id', 'message'];

    public function SellDeal() {
    	return $this->belongsTo('App\Model\SellDeal');
    }
}
