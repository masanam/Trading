<?php

namespace App\Model;

use Laravel\Scout\Searchable;

use App\Model\User;
use App\Model\BuyerUser;
use App\Model\BuyOrder;
use App\Model\Product;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use Searchable;

    protected $table = 'buyers';

    public function User() {
    	return $this->belongsTo('User');
    }

    public function Contact() {
        return $this->hasMany('Contact');
    }

    public function BuyOrder() {
    	return $this->hasMany('BuyOrder');
    }

    public function Product() {
    	return $this->hasMany('Product');
    }
}
