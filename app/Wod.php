<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wod extends Model
{
	protected $table = 'wod';

    protected $fillable = [ 'title', 'description', 'show_on', 'status'];
}
