<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Assists;
use App\Activity;
use App\ActivityByTutor;
use App\Classes;
use App\ClassDaySchedule;
use App\Classroom;
use App\Inscription;
use App\Schedule;
use App\User;
use Auth;

class AssistsController extends Controller
{
    public function index()
    {
        $assists = Assists::all();

        foreach ($assists as $key) {

            $classes    = Classes::find($key->class_id);
            $classroom  = Classroom::find($classes->classroom_id);
            $classday   = ClassDaySchedule::where('class_id', $classes->id)->first();
            $hour       = Schedule::find($classday->schedule_start_id);
            $activity   = Activity::find($classes->activity_id);
            $actbytutor = ActivityByTutor::where('activity_id', $classes->activity_id)->first();
            $inscription= Inscription::where('classes_days_schedules_id', $classday->id)->first();
            $tutor      = User::find($actbytutor->user_id);
            $client     = User::find($key->user_id);

            $key->client_name    = $client->name ." ". $client->last_name;
            $key->activity_name  = $activity->name;
            $key->tutor_name     = $tutor->name . " ". $tutor->last_name;
            $key->classroom_name = $classroom->name;
            $key->hour           = $hour->description;
            $key->date           = date('Y-m-d', strtotime($key->created_at));
            $key->activities     = array('name' => $activity->name, 'class_id' => $key->class_id);
        }

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
        $activity = Activity::all();
        $response = array();
        $count = 0;

        foreach ($activity as $key) {

            $classes    = Classes::where('activity_id', $key->id)->get();

            foreach ($classes as $class) {
            
                $response[$count]['name'] = $key->name;
                $response[$count]['class_id'] = $class->id;
                $count++;

            }
        }
        
        return view('assists', array('assists' => $response));
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
        $assists->class_id = $request->class_id;
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
