<?php

namespace App\Model;

use App\Model\User;
use App\Model\BuyerUser;
use App\Model\BuyOrder;
use App\Model\Product;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $table = 'buyers';

    public function user() {
    	return $this->belongsTo('User');
    }

    public function contact() {
        return $this->hasMany('Contact');
    }

    public function BuyOrder() {
    	return $this->hasMany('BuyOrder');
    }

    public function product() {
    	return $this->hasMany('Product');
    }
}
