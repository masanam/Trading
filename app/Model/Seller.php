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
    protected $table = 'sellers';

    public function User() {
    	return $this->belongsTo('App\Model\User');
    }

    public function Contact() {
        return $this->hasMany('App\Model\Contact')->where('status','a');
    }

    public function SellOrder() {
    	return $this->hasMany('App\Model\SellOrder')->orderBy('order_date', 'desc');
    }

    public function Product() {
    	return $this->hasMany('App\Model\Product');
    }

    public function Concession() {
    	return $this->hasMany('App\Model\Concession');
    }
}
