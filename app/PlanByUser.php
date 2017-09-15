<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanByUser extends Model
{
	protected $table = 'plans_by_user';

    protected $fillable = [ 'plans_id', 'user_id'];


    public function plans() {
      return $this->belongsTo('App\Plans');
    }

    public function user() {
      return $this->belongsTo('App\User');
    }

}
