<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use View;
use Img;
use App\Classroom;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class ClassroomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classrooms = Classroom::all();
        if (Auth::check()) {
            if(!isset($classrooms)){
                return view('list.classrooms_list');
            } else {
               return view('list.classrooms_list', compact('classrooms'));
            }
        } else {
            return $classrooms;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('classrooms');
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
            'name' => 'required | max:255 | unique:classrooms', 
            'm2' => 'required | integer',
        ]); 

        if ($validator->fails()) {
            return redirect('classrooms/create')
            ->withErrors($validator)
            ->withInput();
        }

        $classrooms = new Classroom;

        if($request->file('file')) {
            $image = $request->file('file');
            $imageName = $request->file('file')->getClientOriginalName();
            $path_t = public_path('storage/thumb_' . $imageName);
            $path = public_path('storage/' . $imageName);
            Img::make($image->getRealPath())->resize(240,200)->save($path_t);
            Img::make($image->getRealPath())->save($path);
            $classrooms->image = $imageName;
        }

        /*if($request->file('video')) {        

            $videoDocument = $request->file('video');
            $videofile = $videoDocument->getClientOriginalName();
            $pathVideo = public_path('storage/video/' . $videofile);
            $request->file('video')->move('storage/video/', $pathVideo);
            $classrooms->video = $videofile;

        } */

        $classrooms->name = $request->name;
        $classrooms->observation = $request->observation;
        $classrooms->m2 = $request->m2;
        $classrooms->status = $request->status;
        $classrooms->type = $request->type;
        $classrooms->save();

        return redirect()->route('classrooms.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $classrooms = Classroom::find($id);

        return view('classrooms', compact('classrooms'));
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
            'name' => 'required | max:255 | unique:classrooms,id,'.$id, 
            'm2' => 'required | integer',
        ]); 

        if ($validator->fails()) {
            return redirect('classrooms/'.$id)
            ->withErrors($validator)
            ->withInput();
        }

        $classrooms = Classroom::findOrFail($id);

        if($request->file('file')) {
            $image = $request->file('file');
            $imageName = $request->file('file')->getClientOriginalName();
            $path_t = public_path('storage/thumb_' . $imageName);
            $path = public_path('storage/' . $imageName);
            Img::make($image->getRealPath())->resize(240,200)->save($path_t);
            Img::make($image->getRealPath())->save($path);
            $classrooms->image = $imageName;
        }

       /* if($request->file('video')) {        

            $videoDocument = $request->file('video');
            $videofile = $videoDocument->getClientOriginalName();
            $pathVideo = public_path('storage/video/' . $videofile);
            $request->file('video')->move('storage/video/', $pathVideo);
            $classrooms->video = $videofile;

        } */

        $classrooms->name = $request->name;
        $classrooms->observation = $request->observation;
        $classrooms->m2 = $request->m2;
        $classrooms->status = $request->status;
        $classrooms->save();

        return redirect()->route('classrooms.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $classrooms = Classroom::findOrFail($id);
        $classrooms->delete();
        return redirect()->route('classrooms.index');
    }
}
