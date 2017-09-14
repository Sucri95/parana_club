<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quizzes extends Model
{
	protected $table = 'quizzes';

    protected $fillable = [ 'question', 'answer', 'categories_id', 'status'];

	/* SOLO RETORNA QUIZZES CON ANSWERS */
    public static function withAnswer()
    {
      return static::leftJoin(
        'quizzes_options',
        'quizzes_options.quizzes_id', '=', 'quizzes.id'
      )->where('quizzes.answer', 1)->where('quizzes_options.answer', 1);

    }

    public function categories() {
      return $this->belongsTo('App\Category');
    }
}
