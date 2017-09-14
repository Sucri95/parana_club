<?php

namespace App\Http\Controllers;
use Auth;
use Validator;
use View;
use Img;
use App\PaidTutors;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class PaidTutorsController extends Controller
{
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paid_tutors = PaidTutors::all();
        if (Auth::check()) {
            if(!isset($paid_tutors)){
                return view('list.paid_tutors_list');
            } else {
               return view('list.paid_tutors_list', compact('paid_tutors'));
            }
        } else {
            return $paid_tutors;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('paid_tutors');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $paid_tutors = new PaidTutors;

        $paid_tutors->save();

        return redirect()->route('paid_tutors.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $paid_tutors = PaidTutors::find($id);

        return view('paid_tutors', compact('paid_tutors'));
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



        $paid_tutors = PaidTutors::findOrFail($id);

        $paid_tutors->save();

        return redirect()->route('paid_tutors.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paid_tutors = PaidTutors::findOrFail($id);
        $paid_tutors->delete();
        return redirect()->route('paid_tutors.index');
    }

}
