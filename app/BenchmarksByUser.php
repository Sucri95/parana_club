<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BenchmarksByUser extends Model
{	
	protected $table = 'benchmars_by_user';

    protected $fillable = [ 'benchmars_id', 'user_id', 'value'];

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function benchmars() {
    	return $this->belongsTo('App\Benchmark');
    }

}
