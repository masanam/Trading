<?php

namespace App\Model;

use App\Model\BuyOrder;
use App\Model\Chat;
use App\Model\BuyDealApproval;
use App\Model\Deal;

use Illuminate\Database\Eloquent\Model;

class BuyDeal extends Model
{
    protected $table = 'buy_deal';

    public function BuyOrder() {
    	return $this->belongsTo('App\Model\BuyOrder');
    }

    public function Chat() {
    	return $this->belongsTo('App\Model\Chat');
    }

    public function BuyDealApproval() {
        return $this->hasMany('App\Model\BuyDealApproval');
    }

    public function Deal() {
    	return $this->belongsTo('App\Model\Deal');
    }
}
