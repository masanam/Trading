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
        'na20_min',
        'na20_max',
    ];

    /*public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }*/

    public function company() {
    	return $this->belongsTo(Company::class);
    }

    public function concession() {
    	return $this->belongsTo(Concession::class);
    }

    public function sales_target() {
        return $this->hasMany(SalesTarget::class);
    }

    public function shipment() {
        return $this->hasMany(Shipment::class);
    }

    

    public function difference($compare, $company_type){
        if($this->company->company_type = $company_type){
            $this->gcv_adb_min_diff = abs($this->gcv_adb_min - $compare->gcv_adb_min);
            $this->gcv_adb_max_diff = abs($this->gcv_adb_max - $compare->gcv_adb_max);
            $this->gcv_arb_min_diff = abs($this->gcv_arb_min - $compare->gcv_arb_min);
            $this->gcv_arb_max_diff = abs($this->gcv_arb_max - $compare->gcv_arb_max);
            $this->ncv_min_diff = abs($this->ncv_min - $compare->ncv_min);
            $this->ncv_max_diff = abs($this->ncv_max - $compare->ncv_max);
        }
    }
}
