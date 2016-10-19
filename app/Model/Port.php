<?php

namespace App\Model;

use App\Model\Buyer;
use App\Model\Seller;

use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    protected $table = 'ports';

    public function BuyerPort() {
    	return $this->belongsTo('App\Model\BuyerPort');
    }

    public function SellerPort() {
    	return $this->belongsTo('App\Model\SellerPort');
    }
}
