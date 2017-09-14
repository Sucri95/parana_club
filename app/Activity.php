<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
	protected $table = 'activities';

    protected $fillable = [ 'name', 'description', 'image', 'm2', 'status',  ];

    public function activitiesByTutor() 
	{
	    return $this->hasMany('App\ActivityByTutor');
	}
}
