<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
	protected $table = 'tasks';

    protected $fillable = [ 'resposable_user_id', 'user_id', 'description', 'show_on', 'all_days', 'status', 'all_employees', 'code'];

    //User_id es el que genera la tarea, responsable_user_id  el responsable de realizar la tarea

    public function resposable_user() {
      return $this->belongsTo('App\User');
    }

    public function user() {
      return $this->belongsTo('App\User');
    }


}
