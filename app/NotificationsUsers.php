<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationsUsers extends Model
{
	protected $table = 'notifications_users';

    protected $fillable = [ 'user_id', 'notifications_id', 'status' ];

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function notifications() {
    	return $this->belongsTo('App\Notifications');
    }


}
