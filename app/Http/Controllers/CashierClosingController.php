<?php

namespace App\Http\Controllers;
use App\CashierClosing;
use View;
use Auth;
use Validator;
use Illuminate\Http\Request;

class CashierClosingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cashier_closing = CashierClosing::with('responsable_user')->get();
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            if(!isset($cashier_closing)){
                return view('list.cashier_closing_list');
            } else {
               return view('list.cashier_closing_list', compact('cashier_closing'));
            }
        } else if (Auth::check() && Auth::user()->hasRole('user')){
            return response(view('errors.404'), 404);

        } else {
            return $cashier_closing;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('cashier_closing', compact('number'));
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
            'amount' => 'required', 
        ]); 

        if ($validator->fails()) {
            return redirect('cashier_closing/create')
            ->withErrors($validator)
            ->withInput();
        }

        $cashier_closing = new CashierClosing;
        $cashier_closing->responsable_user_id = Auth::user()->id;
        $cashier_closing->client_user_id = $request->client_user_id;
        $cashier_closing->type_cashier_closing_id = $request->type_cashier_closing_id;
        $cashier_closing->amount = $request->amount;
        $cashier_closing->meta = $request->meta;
        $cashier_closing->meta_id = $request->meta_id;
        $cashier_closing->description = $request->description;
        $cashier_closing->status = 'Activo';
        $cashier_closing->save();

        return redirect()->route('cashier_closing.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return View::make('cashier_closing')->with('cashier_closing', CashierClosing::find($id));
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
        $cashier_closing = CashierClosing::findOrFail($id);
        $cashier_closing->responsable_user_id = Auth::user()->id;
        $cashier_closing->client_user_id = $request->client_user_id;
        $cashier_closing->type_cashier_closing_id = $request->type_cashier_closing_id;
        $cashier_closing->amount = $request->amount;
        $cashier_closing->meta = $request->meta;
        $cashier_closing->meta_id = $request->meta_id;
        $cashier_closing->description = $request->description;
        $cashier_closing->status = 'Activo';
        $cashier_closing->save();

        return redirect()->route('cashier_closing.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cashier_closing = CashierClosing::findOrFail($id);
        $cashier_closing->delete();
        return redirect()->route('cashier_closing.index');
    }

}
