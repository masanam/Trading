<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Index extends Model
{
    protected $table = "index";

    public function indexPrices() {
      return $this->hasMany(IndexPrice::class, 'index_id');
    }

    public function latestIndexPrice () {
      return $this->hasOne(IndexPrice::class, 'index_id')->orderBy('date', 'DESC');
    }

    public function earliestIndexPrice () {
      return $this->hasOne(IndexPrice::class, 'index_id')->orderBy('date', 'ASC');
    }

    /*public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }*/
}
