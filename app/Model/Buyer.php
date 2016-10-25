<?php

namespace App\Model;

use Laravel\Scout\Searchable;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $table = 'buyers';

    public function User() {
    	return $this->belongsTo('App\Model\User');
    }

    public function Contact() {
        return $this->hasMany('App\Model\Contact');
    }

    public function BuyUser() {
        return $this->hasMany('App\Model\BuyUser');
    }

    public function BuyOrder() {
    	return $this->hasMany('App\Model\BuyOrder')->orderBy('order_date', 'desc');
    }

    public function Product() {
    	return $this->hasMany('App\Model\Product');
    }
}
