<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use View;
use Img;
use App\Activity;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;



class ActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = Activity::all();
        if (Auth::check()) {
            if(!isset($activities)){
                return view('list.activities_list');
            } else {
               return view('list.activities_list', compact('activities'));
            }
        } else {
            return $activities;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('activities');
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
            'name' => 'required | max:255 | unique:activities', 
            'm2' => 'required | integer ',
        ]); 

        if ($validator->fails()) {
            return redirect('activities/create')
            ->withErrors($validator)
            ->withInput();
        }

        $activities = new Activity;

        if($request->file('file')) {
            $image = $request->file('file');
            $imageName = $request->file('file')->getClientOriginalName();
            $path_t = public_path('storage/thumb_' . $imageName);
            $path = public_path('storage/' . $imageName);
            Img::make($image->getRealPath())->resize(240,200)->save($path_t);
            Img::make($image->getRealPath())->save($path);
            $activities->image = $imageName;
        }

        /*if($request->file('video')) {        

            $videoDocument = $request->file('video');
            $videofile = $videoDocument->getClientOriginalName();
            $pathVideo = public_path('storage/video/' . $videofile);
            $request->file('video')->move('storage/video/', $pathVideo);
            $activities->video = $videofile;

        } */

        $activities->name = $request->name;
        $activities->description = $request->description;
        $activities->m2 = $request->m2;
        $activities->status = $request->status;
        $activities->save();

        return redirect()->route('activities.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $activities = Activity::find($id);

        return view('activities', compact('activities'));
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
            'name' => 'required | max:255 | unique:activities,id,'.$id, 
            'm2' => 'required | integer',
        ]); 

        if ($validator->fails()) {
            return redirect('activities/'.$id)
            ->withErrors($validator)
            ->withInput();
        }

        $activities = Activity::findOrFail($id);

        if($request->file('file')) {
            $image = $request->file('file');
            $imageName = $request->file('file')->getClientOriginalName();
            $path_t = public_path('storage/thumb_' . $imageName);
            $path = public_path('storage/' . $imageName);
            Img::make($image->getRealPath())->resize(240,200)->save($path_t);
            Img::make($image->getRealPath())->save($path);
            $activities->image = $imageName;
        }

       /* if($request->file('video')) {        

            $videoDocument = $request->file('video');
            $videofile = $videoDocument->getClientOriginalName();
            $pathVideo = public_path('storage/video/' . $videofile);
            $request->file('video')->move('storage/video/', $pathVideo);
            $activities->video = $videofile;

        } */

        $activities->name = $request->name;
        $activities->description = $request->description;
        $activities->m2 = $request->m2;
        $activities->status = $request->status;
        $activities->save();

        return redirect()->route('activities.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $activities = Activity::findOrFail($id);
        $activities->delete();
        return redirect()->route('activities.index');
    }
}
