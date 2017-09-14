<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $table = 'products';

    protected $fillable = [ 'name', 'cost', 'stock_inicial', 'stock_actual', 'status'];
}
