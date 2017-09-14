<?php

namespace App\Http\Controllers;
use Auth;
use App\Sales;
use App\SalesDetail;
use App\Product;
use App\User;
use App\SalesByUser;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $sales = Sales::all();
        foreach ($sales as $keyvalue) {
            $sales_details = SalesDetail::where('sales_id', $keyvalue->id)->get();
            unset($data);
            foreach ($sales_details as $key) {
                $products = Product::find($key->products_id);
                $key->products = $products;
                $data[] = $key;
            }


            $keyvalue->sales_details = $data;

            $usuario = User::where('id', $keyvalue->user_id)->first(['name', 'last_name', 'email']);
            $keyvalue->usuario = $usuario;
        }
        if (Auth::check()) {
            if(!isset($sales)){
                return view('list.sales_list');
            } else {
               return view('list.sales_list', compact('sales'));
            }

        } else {
            return $sales;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sales');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $sales = new Sales;
        $sales->user_id = Auth::user()->id;
        $sales->total = $request->total;
        $sales->save();

        if(!empty($request->psd)){
            
            $saved = SalesDetail::where('sales_id', $sales->id)->delete();

            foreach ($request->psd as $keyvalue) {


                $data = explode(",", $keyvalue);
                $sales_details = new SalesDetail;
                $sales_details->sales_id = $sales->id;
                $sales_details->products_id = $data[0];
                $sales_details->quantity = $data[1];
                $sales_details->sub_total = $data[2];
                $sales_details->save();

                $products = Product::find($sales_details->products_id);
                $products->stock_actual = $products->stock_actual-$sales_details->quantity;
                $products->save();

            }
        }

        if(!empty($request->uid_user)){

            $sales_by_user = new SalesByUser;
            $sales_by_user->user_id = $request->uid_user;
            $sales_by_user->sales_id = $sales->id;
            $sales_by_user->status = 'Activo';
            $sales_by_user->save();

        }

        return redirect()->route('sales.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sales = Sales::find($id);

        return view('sales', compact('sales'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sales = Sales::findOrFail($id);
        $sales->products_id = $request->product_id;
        $sales->user_id = Auth::user()->id;
        $sales->quantity = $request->quantity;
        $sales->total = $request->total;
        $sales->save();

        return redirect()->route('sales.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sales = Sales::findOrFail($id);
        $sales->delete();
        return redirect()->route('sales.index');
    }
}
