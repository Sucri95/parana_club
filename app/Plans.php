<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plans extends Model
{
	protected $table = 'plans';

    protected $fillable = [ 'title', 'description', 'amount', 'status'];

}
