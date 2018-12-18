<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Loader extends Model
{
    protected $table = 'loaders';
    public function shipment() {
        return $this->hasMany(Shipment::class);
    }
}
