<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesByUser extends Model
{

	protected $table = 'sales_by_user';

    protected $fillable = [ 'sales_id', 'user_id', 'status'];

    //STATUS DE VENTA Activo / Pagado

    public function sales() {
    	return $this->belongsTo('App\Sales');
    }


    public function user() {
    	return $this->belongsTo('App\User');
    }


}
