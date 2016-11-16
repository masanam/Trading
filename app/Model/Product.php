<?php

namespace App\Model;

use App\Model\Buyer;
use App\Model\Seller;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    public function Buyer() {
    	return $this->belongsTo('App\Model\Buyer','buyer_id','id');
    }

    public function Seller() {
    	return $this->belongsTo('App\Model\Seller','seller_id','id');
    }
    
    public function Concession() {
    	return $this->belongsTo('Concession');
    }
}
