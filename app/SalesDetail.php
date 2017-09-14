<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesDetail extends Model
{
	protected $table = 'sales_details';

    protected $fillable = [ 'sales_id', 'products_id', 'sub_total', 'quantity',];


    public function sales() {
    	return $this->belongsTo('App\Sales');
    }

    public function products() {
    	return $this->belongsTo('App\Product');
    }



    public static function withProduct($value)
    {
      return static::leftJoin(
        'products.name',
        'sales_details.products_id', '=', 'products.id'
      )->where('products.id', $value);

    }
}
