<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeCashTransaction extends Model
{
	protected $table = 'type_cash_transactions';

    protected $fillable = [ 'name', 'description', 'status'];
}
