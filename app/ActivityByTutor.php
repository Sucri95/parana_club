<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityByTutor extends Model
{
	protected $table = 'activities_by_tutors';

    protected $fillable = [ 'activity_id', 'user_id', 'percentage_gain'];

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function activity() {
    	return $this->belongsTo('App\Activity', 'id');
    }
}
