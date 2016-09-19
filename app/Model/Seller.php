<?php

namespace App\Model;

use Laravel\Scout\Searchable;

use App\Model\User;
use App\Model\SellOrder;
use App\Model\Product;
use App\Model\Mine;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use Searchable;

    protected $table = 'sellers';

    public function User() {
    	return $this->belongsTo('User');
    }

    public function Contact() {
        return $this->hasMany('Contact');
    }

    public function SellOrder() {
    	return $this->hasMany('SellOrder');
    }

    public function Product() {
    	return $this->hasMany('Product');
    }

    public function Mine() {
    	return $this->hasMany('Mine');
    }
}
