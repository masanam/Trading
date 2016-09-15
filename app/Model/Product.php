<?php

namespace App\Model;

use App\Model\Buyer;
use App\Model\Seller;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    public function buyer() {
    	return $this->belongsTo('Buyer');
    }

    public function seller() {
    	return $this->belongsTo('Seller');
    }
}
