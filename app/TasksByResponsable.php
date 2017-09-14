<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TasksByResponsable extends Model
{

	//ESTA CLASE ES PARA CUANDO REALIZA LAS TAREAS SABER A QUE HORA LA COMPLETÓ
	
	protected $table = 'tasks_by_responsable';

    protected $fillable = [ 'resposable_user_id', 'tasks_id', ];

    public function tasks() {
    	return $this->belongsTo('App\Tasks');
    }

    public function user() {
      return $this->belongsTo('App\User');
    }
    
}
