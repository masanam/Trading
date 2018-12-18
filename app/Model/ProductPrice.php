<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    protected $table = 'product_prices';
    protected $fillable = [
        'id',
        'product_id',
        'date',
        'cv',
        'tm',
        'ts',
        'ash',
        'aft',
        'fc',
        'vm',
        'fe203',
        'im',
        'hardness',
        'size',
        'sulphur',
        'na2o',
        'barging',
        'discount',
        'price'
    ];


    public function product() {
        return $this->belongsTo(Product::class);
    }

    // public function productPriceHistory() {
    //     return $this->hasMany(Product::class);
    // }

    /*public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }*/

 

    

   
}
