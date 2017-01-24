<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// use Mpociot\Firebase\SyncsWithFirebase;

class OrderApproval extends Model
{
    // use SyncsWithFirebase;

    protected $table = 'order_approvals';

    public function getOrderIdAttribute($value) {
      return $value;
    }

    public function getStatusAttribute($value) {
      return $value;
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
