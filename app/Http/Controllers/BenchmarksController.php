<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Benchmark;
use View;
use Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Validator;



class BenchmarksController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $benchmarks = Benchmark::all();
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            if(!isset($benchmarks)){
                return view('list.benchmarks_list');
            } else {
               return view('list.benchmarks_list', compact('benchmarks'));
            }
        } else if (Auth::check() && Auth::user()->hasRole('user')){
            return response(view('errors.404'), 404);

        } else {
            return $benchmarks;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('benchmarks');
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
            'item' => 'required | max:255 | unique:benchmarks', 
        ]); 

        if ($validator->fails()) {
            return redirect('benchmarks/create')
            ->withErrors($validator)
            ->withInput();
        }

        $benchmarks = new Benchmark;
        $benchmarks->item = $request->item;
        $benchmarks->description = $request->description;
        $benchmarks->status = $request->status;
        $benchmarks->save();

        return redirect()->route('benchmarks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return View::make('benchmarks')->with('benchmarks', Benchmark::find($id));
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
        $benchmarks = Benchmark::findOrFail($id);
        $benchmarks->item = $request->item;
        $benchmarks->status = $request->status;
        $benchmarks->save();

        return redirect()->route('benchmarks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $benchmarks = Benchmark::findOrFail($id);
        $benchmarks->delete();
        return redirect()->route('benchmarks.index');
    }
}
