<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CostTotal extends Model
{

    protected $table = 'cost_total';

    public function costHeader() {
        return $this->belongsTo(CostHeader::class,'header_id');
    }

}
