<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Factory extends Model
{
    protected $table = 'factory';

    public function Buyer() {
    	return $this->belongsTo('App\Model\Buyer');
    }
    
    public function Product() {
        return $this->hasMany('App\Model\Product');
    }

    public function Port() {
    	return $this->belongsTo('App\Model\Port');
    }
}
