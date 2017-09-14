<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
	protected $table = 'classrooms';

    protected $fillable = [ 'name', 'observation', 'm2', 'image', 'status'];
}
