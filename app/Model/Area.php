<?php

namespace App\Model;

use Laravel\Scout\Searchable;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
  protected $table = 'areas';

  protected $fillable = [
    'description',
  ];

  public $timestamps = false;

  public function companies() {
    return $this->hasMany(Company::class);
  }

  public function users() {
    return $this->belongsTo(User::class);
  }
}
