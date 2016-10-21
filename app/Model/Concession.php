<?php

namespace App\Model;

use App\Model\Seller;
use App\Model\Product;

use Illuminate\Database\Eloquent\Model;

class Concession extends Model
{
    protected $table = 'concession';

    public function Seller() {
    	return $this->belongsTo('App\Model\Seller');
    }
    
    public function Product() {
        return $this->hasMany('App\Model\Product');
    }

    public function Port() {
    	return $this->belongsTo('App\Model\Port');
    }
}
