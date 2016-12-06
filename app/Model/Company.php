<?php

namespace App\Model;

use Laravel\Scout\Searchable;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
  protected $table = 'companies';

  protected $fillable = [
    'company_name',
    'is_affiliated',
    'phone',
    'email',
    'web',
    'address',
    'city',
    'country',
    'industry',
    'annual_demand',
    'annual_sales',
    'preferred_trading_term',
    'preferred_trading_term_detail',
    'preferred_payment_term',
    'preferred_payment_term_detail',
    'purchasing_countries',
    'description',
  ];

  public function user() {
    return $this->belongsTo(User::class);
  }

  public function contacts() {
    return $this->hasMany(Contact::class);
  }

  public function products() {
    return $this->hasMany(Product::class);
  }

  public function ports() {
    return $this->belongsToMany(Port::class, 'company_port', 'company_id', 'port_id');
  }

  public function factories() {
    return $this->hasMany(Factory::class)->where('status','a');
  }

  public function concessions() {
    return $this->hasMany(Concession::class)->where('status','a');
  }
}