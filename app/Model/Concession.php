<?php

namespace App\Model;

use App\Model\Company;
use App\Model\Product;

use Illuminate\Database\Eloquent\Model;

class Concession extends Model
{
    protected $table = 'concessions';

    protected $fillable = [
        'concession_name',
        'company_id',
        'owner',
        'address',
        'city',
        'country',
        'latitude',
        'longitude',
        'polygon',
        'size',
        'stripping_ratio',
        'resource',
        'reserves',
        'contracted_volume',
        'remaining_volume',
        'annual_production',
        'hauling_road_name',
        'stockpile_capacity',
        'stockpile_coverage',
        'stockpile_distance',
        'port_id',
        'port_distance',
        'license_expiry_date',
        'license_type',
        'status',
        'latitude',
        'longitude',
        'stripping_ratio'
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
