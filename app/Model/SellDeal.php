<?php

namespace App\Model;

use App\Model\SellOrder;
use App\Model\Chat;
use App\Model\SellDealApproval;
use App\Model\Deal;

use Illuminate\Database\Eloquent\Model;

class SellDeal extends Model
{
    protected $table = 'sell_deal';

    public function SellOrder() {
    	return $this->belongsTo('App\Model\SellOrder');
    }

    public function Chat() {
        return $this->belongsTo('App\Model\Chat');
    }

    public function SellDealApproval() {
        return $this->hasMany('App\Model\SellDealApproval');
    }

    public function Deal() {
    	return $this->belongsTo('App\Model\Deal');
    }

    public function User() {
        return $this->belongsTo('App\Model\User');
    }
}
