<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CashTransaction;
use App\User;
use App\Product;
use App\SalesByUser;
use App\SalesDetail;
use App\Activity;
use App\ActivityByTutor;
use App\Classes;
use App\ClassDaySchedule;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $transactions = CashTransaction::all();
        $products = Product::all();

        $today_transactions = array();
        $response = array();
        $user_debts = array();
        $tutor_payment = array();
        $count = 0;
        $total = 0;
        $total_debt = 0;
        $amount_cash = 0;
        $amount_diff = 0;
        $amount_deposits = 0;

        $employees = User::whereHas('roles', function ($query) {
         $query->where('name', '=', 'employee');
        })->count();

        $clients = User::whereHas('roles', function ($query) {
         $query->where('name', '=', 'user');
        })->count();

        $tutors = User::whereHas('roles', function ($query) {
         $query->where('name', '=', 'tutor');
        })->get();

        foreach ($tutors as $user) {
            
            $activity_tutor = ActivityByTutor::where('user_id', $user->id)->first();
            $activity = Activity::where('id', $activity_tutor->activity_id)->first();
            $class = Classes::where('user_id', $user->id)->first();
            $classes = ClassDaySchedule::where('class_id', $class->id)->first();

            $amount_to_pay = ($activity_tutor->percentage_gain * $classes->value) / 100;

            $tutor_payment[$count]['tutor'] = $user->name .' '.$user->last_name;
            $tutor_payment[$count]['class'] = $activity->name;
            $tutor_payment[$count]['amount'] = $amount_to_pay;

            $count++;
        }

        $count = 0;

        $sales_by_user = SalesByUser::with('sales')->with('user')
                        ->where('status', 'Activo')
                        ->groupBy('user_id')
                        ->get();


        foreach ($sales_by_user as $keyvalue) {

            $sales_detail = SalesDetail::with('products')->where('sales_id', $keyvalue->sales_id)->get();

            $user = User::findOrFail($keyvalue->user_id);

            $user_debts[$count]['usuario'] = $user->name.' ' .$user->last_name;
            $user_debts[$count]['documento']  = $user->document;
            
            foreach ($sales_detail as $value) {
                $total_debt = $total_debt + ($value->sub_total * $value->quantity);
            }

            $user_debts[$count]['total'] = $total_debt;
            $count++;
        }

        $count = 0;
            
        foreach ($transactions as $keyvalue) {
            if ( date('Y-m-d', strtotime($keyvalue->created_at)) == date('Y-m-d') && $keyvalue->type_cash_transactions_id != 4) {
                $today_transactions[$count] = $keyvalue;
                $count++;
            }
        }

        foreach ($today_transactions as $keyvalue) {

            if ($keyvalue->type_cash_transactions_id == 1) {
                
                $total = $total + $keyvalue->amount;
                $amount_cash = $amount_cash + $keyvalue->amount;

            }elseif ($keyvalue->type_cash_transactions_id == 2) {
                
                $total = $total - $keyvalue->amount;
                $amount_diff = $amount_diff + $keyvalue->amount;

            }elseif ($keyvalue->type_cash_transactions_id == 3) {

                $total = $total + $keyvalue->amount;
                $amount_deposits = $amount_deposits + $keyvalue->amount;
            }
        }

        if ($total > 0) {
            $response['class'] = 'success';
        }else{
            $response['class'] = 'failed';
        }

        $response['cash']     = $amount_cash;
        $response['diff']     = $amount_diff;
        $response['deposits'] = $amount_deposits;
        $response['total']    = $total;
        $response['employees']= $employees;
        $response['clients']  = $clients;
        $response['tutor']    = count($tutors);
        $response['products'] = $products;
        $response['debts']    = $user_debts;
        $response['payments'] = $tutor_payment;


        return view('home', array('balance' => $response));
    }
}
