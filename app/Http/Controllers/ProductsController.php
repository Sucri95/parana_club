<?php

namespace App\Http\Controllers;
use Auth;
use Validator;
use View;
use Img;
use App\Product;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        if (Auth::check()) {
            if(!isset($products)){
                return view('list.products_list');
            } else {
               return view('list.products_list', compact('products'));
            }
        } else {
            return $products;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        /*$validator = Validator::make($request->all(), [
            'file' => 'image',
            'video' => 'mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4',
        ]); */

        $validator = Validator::make($request->all(), [
            'name' => 'required | max:255 | unique:products', 
            'cost' => 'required | integer', 
            'stock_inicial' => 'required | integer',
        ]); 

        if ($validator->fails()) {
            return redirect('products/create')
            ->withErrors($validator)
            ->withInput();
        }

        $products = new Product;

        $products->name = $request->name;
        $products->cost = $request->cost;
        $products->stock_inicial = $request->stock_inicial;
        $products->stock_actual = $request->stock_inicial;
        $products->status = $request->status;
        $products->save();

        return redirect()->route('products.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $products = Product::find($id);

        return view('products', compact('products'));
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

        $validator = Validator::make($request->all(), [
            'name' => 'required | max:255 | unique:products,id,'.$id, 
            'cost' => 'required | integer', 
            'stock_inicial' => 'required | integer',
        ]); 

        if ($validator->fails()) {
            return redirect('products/'.$id)
            ->withErrors($validator)
            ->withInput();
        }

        $products = Product::findOrFail($id);
        $products->name = $request->name;
        $products->cost = $request->cost;
        $products->stock_inicial = $request->stock_inicial;
        $products->stock_actual = $request->stock_inicial;
        $products->status = $request->status;
        $products->save();

        return redirect()->route('products.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $products = Product::findOrFail($id);
        $products->delete();
        return redirect()->route('products.index');
    }

    public function autocomplete(){
        $term = Str::lower(Input::get('term'));
              
        $results = array();
        
        $queries = DB::table('products')
            ->where('name', 'LIKE', '%'.$term.'%')
            ->take(5)->get();
        
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->id, 'value' => $query->name, 'price' => $query->cost ];
        }

        return  $this->prepareResponse($results);
    }

}
