<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Benchmark extends Model
{	
	protected $table = 'benchmarks';

    protected $fillable = [ 'item', 'status'];
}
