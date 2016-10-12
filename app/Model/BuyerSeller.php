<?php

namespace App\Model;

use App\Model\Seller;
use App\Model\Buyer;

use Illuminate\Database\Eloquent\Model;

class BuyerSeller extends Model
{
    protected $table = 'buyer_seller';

    public function Buyer() {
    	return $this->belongsTo('Buyer');
    }

    public function Seller() {
    	return $this->belongsTo('Seller');
    }
}
