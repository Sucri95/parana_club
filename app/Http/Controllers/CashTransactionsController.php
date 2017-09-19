<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\CashTransaction;
use App\CashierClosing;
use View;
use Auth;
use Validator;
use Illuminate\Http\Request;

class CashTransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cash_transactions = CashTransaction::with('responsable_user')->get();
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            if(!isset($cash_transactions)){
                return view('list.cash_transactions_list');
            } else {
               return view('list.cash_transactions_list', compact('cash_transactions'));
            }
        } else if (Auth::check() && Auth::user()->hasRole('user')){
            return response(view('errors.404'), 404);

        } else {
            return $cash_transactions;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('cash_transactions', compact('number'));
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
            return redirect('cash_transactions/create')
            ->withErrors($validator)
            ->withInput();
        }

        $cash_transactions = new CashTransaction;
        $cash_transactions->responsable_user_id = Auth::user()->id;
        $cash_transactions->client_user_id = $request->client_user_id;
        $cash_transactions->type_cash_transactions_id = $request->type_cash_transactions_id;
        $cash_transactions->amount = $request->amount;
        $cash_transactions->meta = $request->meta;
        $cash_transactions->meta_id = $request->meta_id;
        $cash_transactions->description = $request->description;
        $cash_transactions->status = 'Activo';
        $cash_transactions->save();

        return redirect()->route('cash_transactions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return View::make('cash_transactions')->with('cash_transactions', CashTransaction::find($id));
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
        $cash_transactions = CashTransaction::findOrFail($id);
        $cash_transactions->responsable_user_id = Auth::user()->id;
        $cash_transactions->client_user_id = $request->client_user_id;
        $cash_transactions->type_cash_transactions_id = $request->type_cash_transactions_id;
        $cash_transactions->amount = $request->amount;
        $cash_transactions->meta = $request->meta;
        $cash_transactions->meta_id = $request->meta_id;
        $cash_transactions->description = $request->description;
        $cash_transactions->status = 'Activo';
        $cash_transactions->save();

        return redirect()->route('cash_transactions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cash_transactions = CashTransaction::findOrFail($id);
        $cash_transactions->delete();
        return redirect()->route('cash_transactions.index');
    }


    //Cierre de caja
    //Route: transactions/close_day
    public function closeDay(Request $request)
    {

        $transactions = CashTransaction::all();
        $today_transactions = array();
        $response = array();
        $count = 0;
        $total = 0;
        $amount_cash = 0;
        $amount_diff = 0;
        $amount_deposits = 0;
        $closingday = new CashierClosing;

        foreach ($transactions as $keyvalue) {
            if ( date('Y-m-d', strtotime($keyvalue->created_at)) == date('Y-m-d') && $keyvalue->type_cash_transactions_id != 4) {
                $today_transactions[$count] = $keyvalue;
                $count++;
            }
        }

        foreach ($today_transactions as $keyvalue) {

            if ($keyvalue->type_cash_transactions_id == 1) {
                
                $total = $total + $keyvalue->amount;
                $amount_cash++;

            }elseif ($keyvalue->type_cash_transactions_id == 2) {
                
                $total = $total - $keyvalue->amount;
                $amount_diff++;

            }elseif ($keyvalue->type_cash_transactions_id == 3) {

                $total = $total + $keyvalue->amount;
                $amount_deposits++;
            }
        }

        $closingday->responsable_user_id = $request->responsable_user_id;
        $closingday->amount_cash = $amount_cash;
        $closingday->amount_diff = $amount_diff;
        $closingday->amount_deposits = $amount_deposits;
        $closingday->observation = $request->observation;
        $closingday->status = $request->status;
        $closingday->save();

        $cash_transactions = new CashTransaction;
        $cash_transactions->responsable_user_id = $request->responsable_user_id;
        $cash_transactions->type_cash_transactions_id = "4";
        $cash_transactions->amount = $total;
        $cash_transactions->meta = "Cierre";
        $cash_transactions->meta_id = $closingday->id;
        $cash_transactions->description = $request->observation;
        $cash_transactions->status = $request->status;
        $cash_transactions->save();


        $response['cashier_closing'] = $closingday;
        $response['cash_transactions'] = $cash_transactions;

        return $response;
        
    }

}
