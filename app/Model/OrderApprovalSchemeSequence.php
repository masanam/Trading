<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderApprovalSchemeSequence extends Model
{
  protected $table = 'order_approval_scheme_sequences';

	protected $fillable = array('order_approval_scheme_id', 'sequence', 'role_id', 'approval_scheme');

	public function approvalscheme() {
    return $this->belongsToMany(Role::class, 'role_id');
  }
}
