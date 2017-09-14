<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\CashDeposit;
use View;
use Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Validator;

class CashDepositsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cash_deposits = CashDeposit::with('responsable_user')->get();
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            if(!isset($cash_deposits)){
                return view('list.cash_deposits_list');
            } else {
               return view('list.cash_deposits_list', compact('cash_deposits'));
            }
        } else if (Auth::check() && Auth::user()->hasRole('user')){
            return response(view('errors.404'), 404);

        } else {
            return $cash_deposits;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cash_deposits = CashDeposit::orderBy('created_at', 'desc')->first();
        if(!empty($cash_deposits)){
            $number = $cash_deposits->deposit_number+1;
        } else {
            $number = 1;

        }

        return view('cash_deposits', compact('number'));
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
            return redirect('cash_deposits/create')
            ->withErrors($validator)
            ->withInput();
        }

        $cash_deposits = new CashDeposit;
        $cash_deposits->responsable_user_id = Auth::user()->id;
        $cash_deposits->amount = $request->amount;
        $cash_deposits->deposit_number = $request->deposit_number;
        $cash_deposits->status = 'Activo';
        $cash_deposits->save();

        return redirect()->route('cash_deposits.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return View::make('cash_deposits')->with('cash_deposits', CashDeposit::find($id));
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
        $cash_deposits = CashDeposit::findOrFail($id);
        $cash_deposits->responsable_user_id = Auth::user()->id;
        $cash_deposits->amount = $request->amount;
        $cash_deposits->deposit_number = $request->deposit_number;
        $cash_deposits->status = $request->status;
        $cash_deposits->save();

        return redirect()->route('cash_deposits.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cash_deposits = CashDeposit::findOrFail($id);
        $cash_deposits->delete();
        return redirect()->route('cash_deposits.index');
    }
}
