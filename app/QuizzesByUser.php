<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizzesByUser extends Model
{
	protected $table = 'quizzes_by_user';

    protected $fillable = [ 'quizzes_id', 'user_id', 'quizzes_options_id'];


    public function quizzes() {
      return $this->belongsTo('App\Quizzes');
    }

    public function user() {
      return $this->belongsTo('App\User');
    }

    public function quizzes_options() {
      return $this->belongsTo('App\QuizzesOptions');
    }

}
