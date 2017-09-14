<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Assists;
use Auth;

class AssistsController extends Controller
{
    public function index()
    {
        $assists = Assists::all();
        if (Auth::check()) {
            if(!isset($assists)){
                return view('list.assists_list');
            } else {
               return view('list.assists_list', compact('assists'));
            }
        } else {
            return $assists;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('assists');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    	$assists = new Assists;
    	$assists->user_id = $request->uid_user;
    	$assists->responsable_user_id = Auth::user()->id;
    	$assists->save();

        return redirect()->route('assists.index');




    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $assists = Assists::find($id);

        return view('assists', compact('assists'));
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


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $assists = Assists::findOrFail($id);
        $assists->delete();
        return redirect()->route('assists.index');
    }
}
