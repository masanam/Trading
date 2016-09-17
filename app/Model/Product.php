<?php

namespace App\Model;

use App\Model\Buyer;
use App\Model\Seller;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    public function Buyer() {
    	return $this->belongsTo('Buyer');
    }

    public function Seller() {
    	return $this->belongsTo('Seller');
    }
}
