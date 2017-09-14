<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashDeposit extends Model
{
	protected $table = 'cash_deposits';

    protected $fillable = [ 'responsable_user_id', 'amount', 'deposit_number', 'status'];

    public function responsable_user() {
    	return $this->belongsTo('App\User');
    }
}
