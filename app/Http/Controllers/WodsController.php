<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Wod;
use View;
use Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Validator;



class WodsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wods = Wod::all();
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            if(!isset($wods)){
                return view('list.wods_list');
            } else {
               return view('list.wods_list', compact('wods'));
            }
        } else if (Auth::check() && Auth::user()->hasRole('user')){
            return response(view('errors.404'), 404);

        } else {
            return $wods;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('wods');
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
            'description' => 'required', 
        ]); 

        if ($validator->fails()) {
            return redirect('wods/create')
            ->withErrors($validator)
            ->withInput();
        }

        $wods = new Wod;
        $wods->title = $request->title;
        $wods->description = $request->description;
        $wods->show_on =date('Y-m-d', strtotime($request->show_on));
        $wods->status = $request->status;
        $wods->save();

        return redirect()->route('wods.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return View::make('wods')->with('wods', Wod::find($id));
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
        $wods = Wod::findOrFail($id);
        $wods->title = $request->title;
        $wods->description = $request->description;
        $wods->show_on =date('Y-m-d', strtotime($request->show_on));
        $wods->status = $request->status;
        $wods->save();

        return redirect()->route('wods.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wods = Wod::findOrFail($id);
        $wods->delete();
        return redirect()->route('wods.index');
    }
}
