<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaidTutors extends Model
{
	protected $table = 'paid_tutors';

    protected $fillable = [ 'tutor_user_id', 'responsable_user_id', 'amount', 'status'];
}
