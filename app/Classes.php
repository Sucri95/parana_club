<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
	protected $table = 'classes';

    protected $fillable = [ 'activity_id', 'user_id', 'classroom_id', 'start_date', 'end_date', 'capacity', 'inscribed', 'status'];

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function activity() {
    	return $this->belongsTo('App\Activity');
    }

    public function classroom() {
    	return $this->belongsTo('App\Classroom');
    }
}
