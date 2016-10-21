<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Mpociot\Firebase\SyncsWithFirebase;

class BuyDealChat extends Model
{
	use SyncsWithFirebase;
	
	protected $table = 'buy_deal_chat';
	protected $fillable = ['buy_deal_id', 'user_id', 'message'];
            
    public function BuyDeal() {
    	return $this->belongsTo('App\Model\BuyDeal');
    }
}
