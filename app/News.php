<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
	protected $table = 'news';

    protected $fillable = [ 'title', 'content', 'status', 'created_user_id', 'image', 'category_id', 'important', 'type' ];


    public function created_user() {
    	return $this->belongsTo('App\User');
    }

    public function category() {
    	return $this->belongsTo('App\User');
    }


}
