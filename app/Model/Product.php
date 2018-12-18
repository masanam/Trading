<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'user_id',
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
        'na2o_min',
        'na2o_max',
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

    public function contract() {
    	return $this->belongsTo(Contract::class);
    }

    public function concession() {
    	return $this->belongsTo(Concession::class);
    }

    // Created By : Martin
    // Tanggal : 27 Maret 2017
    public function production_plan() {
        return $this->hasMany(ProductionPlan::class);
    }

    public function shipment() {
        return $this->hasMany(Shipment::class);
    }

    public function shipmentPlan() {
    return $this->hasMany(Product::class);
  }

    public function product_price() {
        return $this->hasMany(ProductPrice::class);
    }

    public function product_variant() {
        return $this->hasMany(ProductVariant::class);
    }

    public function yearlyPrice() {
        return $this->hasMany(ProductPrice::class)->selectRaw('product_id, IFNULL(AVG(price),0) as price, YEAR(date) as year')->groupBy('product_id', 'year')->orderBy('year', 'DESC');
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
