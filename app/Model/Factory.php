<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Factory extends Model
{
    protected $table = 'factories';

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
