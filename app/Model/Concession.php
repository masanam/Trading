<?php

namespace App\Model;

use App\Model\Seller;
use App\Model\Product;

use Illuminate\Database\Eloquent\Model;

class Concession extends Model
{
    protected $table = 'concessions';

    public function company() {
    	return $this->belongsTo(Company::class);
    }
    
    public function products() {
        return $this->hasMany(Product::class);
    }

    public function port() {
    	return $this->belongsTo(Port::class);
    }
}
