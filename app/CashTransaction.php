<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashTransaction extends Model
{
	protected $table = 'cash_transactions';

    protected $fillable = [ 'responsable_user_id', 'client_user_id', 'type_cash_transactions_id', 'amount', 'meta', 'meta_id', 'description', 'status'];

    public function responsable_user() {
    	return $this->belongsTo('App\User');
    }
    
    public function client_user() {
    	return $this->belongsTo('App\User');
    }

    public function type_cash_transactions() {
    	return $this->belongsTo('App\TypeCashTransction');
    }
}
