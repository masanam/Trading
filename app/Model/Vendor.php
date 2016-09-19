<?php

namespace App\Model;

use Laravel\Scout\Searchable;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
	use Searchable;

    protected $table = "vendors";
}
