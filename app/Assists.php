<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assists extends Model
{
	protected $table = 'assists';

    protected $fillable = [ 'user_id', 'responsable_user_id',  ];

    public function user() {
    	return $this->belongsTo('App\User');
    }
    
    public function responsable_user() {
    	return $this->belongsTo('App\User');
    }

}
