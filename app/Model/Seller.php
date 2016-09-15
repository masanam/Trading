<?php

namespace App\Model;

use App\Model\User;
use App\Model\SellOrder;
use App\Model\Product;
use App\Model\Mine;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $table = 'sellers';

    public function user() {
    	return $this->belongsTo('User');
    }

    public function contact() {
        return $this->hasMany('Contact');
    }

    public function SellOrder() {
    	return $this->hasMany('SellOrder');
    }

    public function product() {
    	return $this->hasMany('Product');
    }

    public function mine() {
    	return $this->hasMany('Mine');
    }
}
