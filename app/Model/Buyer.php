<?php

namespace App\Model;

use Laravel\Scout\Searchable;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use Searchable;

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
    	return $this->hasMany('App\Model\BuyOrder');
    }

    public function Product() {
    	return $this->hasMany('App\Model\Product');
    }

    public function searchableAs()
    {
        return 'buyers_index';
    }

    public function toSearchableArray() {
        return array_only($this->toArray(), [
            'company_name', 'phone', 'email', 'web' , 'industry', 'city', 'address', 'description'
        ]);
    }
}
