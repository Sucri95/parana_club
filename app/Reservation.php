<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';

    protected $fillable = [ 'field_id', 'amount'];

    public function product() {
      return $this->belongsTo('App\Classroom');
    }

}
