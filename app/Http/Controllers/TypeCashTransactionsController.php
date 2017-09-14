<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\TypeCashTransaction;
use View;
use Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Validator;

class TypeCashTransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type_cash_transactions = TypeCashTransaction::all();
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            if(!isset($type_cash_transactions)){
                return view('list.type_cash_transactions_list');
            } else {
               return view('list.type_cash_transactions_list', compact('type_cash_transactions'));
            }
        } else if (Auth::check() && Auth::user()->hasRole('user')){
            return response(view('errors.404'), 404);

        } else {
            return $type_cash_transactions;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('type_cash_transactions');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required | max:255 | unique:type_cash_transactions', 
        ]); 

        if ($validator->fails()) {
            return redirect('type_cash_transactions/create')
            ->withErrors($validator)
            ->withInput();
        }

        $type_cash_transactions = new TypeCashTransaction;
        $type_cash_transactions->name = $request->name;
        $type_cash_transactions->description = $request->description;
        $type_cash_transactions->status = $request->status;
        $type_cash_transactions->save();

        return redirect()->route('type_cash_transactions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return View::make('type_cash_transactions')->with('type_cash_transactions', TypeCashTransaction::find($id));
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
        $type_cash_transactions = TypeCashTransaction::findOrFail($id);
        $type_cash_transactions->name = $request->name;
        $type_cash_transactions->description = $request->description;
        $type_cash_transactions->status = $request->status;
        $type_cash_transactions->save();

        return redirect()->route('type_cash_transactions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type_cash_transactions = TypeCashTransaction::findOrFail($id);
        $type_cash_transactions->delete();
        return redirect()->route('type_cash_transactions.index');
    }
}
