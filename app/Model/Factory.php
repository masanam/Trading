<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Factory extends Model
{
    protected $table = 'factories';
    protected $fillable = [
        'owner', 'address', 'city', 'country', 'latitude', 'longitude',
        'size', 'consumption', 'port_id', 'port_distance', 'factory_name'
    ];

    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

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
