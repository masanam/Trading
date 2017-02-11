<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderApprovalScheme extends Model
{
  protected $table = 'order_approval_schemes';

  public function sequences() {
    return $this->hasMany(OrderApprovalSchemeSequence::class);
  }
}
