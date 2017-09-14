<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
	protected $table = 'sales';

    protected $fillable = [ 'product_id', 'user_id', 'total'];

    public function product() {
      return $this->belongsTo('App\Product');
    }

    public function user() {
      return $this->belongsTo('App\User');
    }
}
