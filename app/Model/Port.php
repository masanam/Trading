<?php

namespace App\Model;

use App\Model\Buyer;
use App\Model\Seller;

use Illuminate\Database\Eloquent\Model;

class Port extends Model {
  protected $table = 'ports';

  public function concessions() {
    return $this->hasMany(Concession::class);
  }

  public function companies() {
    return $this->belongsToMany(Company::class, 'company_port');
  }

}
