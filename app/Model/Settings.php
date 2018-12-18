<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
  protected $table = 'settings';
  protected $fillable = [
      'id',
      'application',
      'variable',
      'value'

  ];

}
