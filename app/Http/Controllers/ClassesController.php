<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use View;
use Img;
use App\User;
use App\Classes;
use App\Activity;
use App\Tutor;
use App\Classroom;
use App\Day;
use App\Schedule;
use App\ClassDaySchedule;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Classes::all();

        foreach ($classes as $key ) {
            $activities = Activity::find($key->activity_id);
            $classroom = Classroom::find($key->classroom_id);
            $tutor = User::find($key->user_id);

            $key->activity_name = $activities->name;
            $key->tutor_name = $tutor->name . " ". $tutor->last_name;
            $key->classroom_name = $classroom->name;
        }



        if (Auth::check()) {
            if(!isset($classes)){
                return view('list.classes_list');
            } else {
               return view('list.classes_list', compact('classes'));
            }
        } else {
            return $classes;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $activities = Activity::all();
        $tutors = Tutor::all();
        $classrooms = Classroom::all();
        $days = Day::all();
        $schedules = Schedule::all();
        return view('classes', compact('activities', 'tutors', 'classrooms', 'days', 'schedules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $classes = new Classes;

        $classes->activity_id = $request->activities;
        $classes->classroom_id = $request->classrooms;
        $classes->user_id = $request->tutor_uid;
        $classes->capacity = $request->capacity;
        $classes->start_date = date('Y-m-d', strtotime($request->start_date));
        $classes->end_date = date('Y-m-d', strtotime($request->end_date));
        $classes->status = $request->status;
        $classes->save();


        if(!empty($request->cds)){

            $saved = ClassDaySchedule::where('class_id', $classes->id)->delete();
            
            foreach ($request->cds as $keyvalue) {

                $data = explode(",", $keyvalue);
                $classes_days_schedules = new ClassDaySchedule;
                $classes_days_schedules->class_id = $classes->id;
                $classes_days_schedules->day_id = $data[0];
                $classes_days_schedules->schedule_start_id = $data[1];
                $classes_days_schedules->schedule_end_id = $data[2];
                $classes_days_schedules->value = $data[3];
                $classes_days_schedules->inscribed = 0;
                $classes_days_schedules->save();

            }
        } else {
            
            $saved = ClassDaySchedule::where('class_id', $classes->id)->delete();

        }

        return redirect()->route('classes.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $activities = Activity::all();
        $tutors = Tutor::all();
        $classrooms = Classroom::all();
        $classes = Classes::find($id);
        $tutor = User::find($classes->user_id);
        $classes->tutor_name = $tutor->name . " " . $tutor->last_name;
        $days = Day::all();
        $schedules = Schedule::all();
        return view('classes', compact('classes', 'activities', 'tutors', 'classrooms', 'days', 'schedules'));
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


        $classes = Classes::findOrFail($id);
        $classes->activity_id = $request->activities;
        $classes->classroom_id = $request->classrooms;
        $classes->user_id = $request->tutor_uid;
        $classes->capacity = $request->capacity;
        $classes->start_date = date('Y-m-d', strtotime($request->start_date));
        $classes->end_date = date('Y-m-d', strtotime($request->end_date));
        $classes->status = $request->status;
        $classes->save();

        if(!empty($request->cds)){
            
            $saved = ClassDaySchedule::where('class_id', $classes->id)->delete();

            foreach ($request->cds as $keyvalue) {

                $data = explode(",", $keyvalue);
                $classes_days_schedules = new ClassDaySchedule;
                $classes_days_schedules->class_id = $classes->id;
                $classes_days_schedules->day_id = $data[0];
                $classes_days_schedules->schedule_start_id = $data[1];
                $classes_days_schedules->schedule_end_id = $data[2];
                $classes_days_schedules->value = $data[3];
                $classes_days_schedules->inscribed = 0;
                $classes_days_schedules->save();
            }
        } else {
            
            $saved = ClassDaySchedule::where('class_id', $classes->id)->delete();

        }

        return redirect()->route('classes.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $classes = Classes::findOrFail($id);
        $classes->delete();
        return redirect()->route('classes.index');
    }

    public function classesDaysSchedules(){
        if(!empty($_GET['class_id'])){
            $data_list = ClassDaySchedule::where('class_id',$_GET['class_id'])->get();
            return $data_list;
        }
    }

    public function classesDaysSchedulesById(){
        if(!empty($_GET['classes_days_schedules_id'])){
            $data = ClassDaySchedule::find($_GET['classes_days_schedules_id']);
            $classes = Classes::find($data->class_id);
            $data->classes = $classes;
            return $data;
        }
    }

    public function classroomsDaysSchedules(){
        if(!empty($_GET['classroom_id'])){
            $classroom = $_GET['classroom_id'];
            $data_list = ClassDaySchedule::withClassroom($classroom)->get();
            return $data_list;
        }
    }


    public function tutorDaysSchedules(){
        if(!empty($_GET['tutor_id'])){
            $tutor = $_GET['tutor_id'];
            $data_list = ClassDaySchedule::withClass($tutor)->get();
            return $data_list;
        }
    }

}