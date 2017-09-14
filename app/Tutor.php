<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
	protected $table = 'tutors';

    protected $fillable = [ 'name', 'last_name', 'phone_number', 'email', 'image', 'status'];
}
