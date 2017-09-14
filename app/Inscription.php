<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
	protected $table = 'inscriptions';

    protected $fillable = [ 'user_id', 'classes_days_schedules_id'];

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function classes_days_schedules() {
    	return $this->belongsTo('App\ClassDaySchedules');
    }
}
