<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashierClosing extends Model
{
	protected $table = 'cashier_closing';

    protected $fillable = [ 'responsable_user_id', 'amount_deposits', 'amount_diff', 'amount_cash', 'observation', 'status'];

    public function responsable_user() {
    	return $this->belongsTo('App\User');
    }
}
