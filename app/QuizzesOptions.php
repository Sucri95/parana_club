<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizzesOptions extends Model
{
	protected $table = 'quizzes_options';

    protected $fillable = [ 'quizzes_id', 'option',];

    public function quizzes() {
      return $this->belongsTo('App\Quizzes');
    }
}
