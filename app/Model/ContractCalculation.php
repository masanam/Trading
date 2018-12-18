<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ContractCalculation extends Model
{
  protected $primaryKey = 'contract_id';

  public $incrementing = false;

  protected $casts = [
    'price_calculation' => 'array',
    'tonnage_calculation' => 'array',
  ];

  public function contracts() {
    return $this->belongsTo(Contract::class, 'contract_id');
  }
}
