<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'product_name',
        'typical_quality',
        'gcv_arb_min',
        'gcv_arb_max',
        'gcv_adb_min',
        'gcv_adb_max',
        'ncv_min',
        'ncv_max',
        'ash_min',
        'ash_max',
        'ts_min',
        'ts_max',
        'tm_min',
        'tm_max',
        'im_min',
        'im_max',
        'fc_min',
        'fc_max',
        'vm_min',
        'vm_max',
        'hgi_min',
        'hgi_max',
        'size_min',
        'size_max',
        'fe2o3_min',
        'fe2o3_max',
        'aft_min',
        'aft_max',
    ];

    public function company() {
    	return $this->belongsTo(Company::class);
    }
    
    public function concession() {
    	return $this->belongsTo(Concession::class);
    }
}
