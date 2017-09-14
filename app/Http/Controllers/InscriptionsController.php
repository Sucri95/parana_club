<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use View;
use Img;
use App\Inscription;
use App\Classes;
use App\Activity;
use App\Classroom;
use App\Day;
use App\Schedule;
use App\ClassDaySchedule;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Input;

class InscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inscriptions = Inscription::all();


        foreach ($inscriptions as $key ) {

            $classes_days_schedules = ClassDaySchedule::find($key->classes_days_schedules_id);
            $classes = Classes::find($classes_days_schedules->class_id);
            $activities = Activity::find($classes->activity_id);
            $classroom = Classroom::find($classes->classroom_id);
            $tutor = User::find($classes->user_id);
            $user = User::find($key->user_id);

            $key->activity_name = $activities->name;
            $key->tutor_name = $tutor->name . " ". $tutor->last_name;
            $key->classroom_name = $classroom->name;
            $key->usuario = $user->name . " " . $user->last_name;
            $key->value = $classes_days_schedules->value;
        }


        if (Auth::check()) {
            if(!isset($inscriptions)){
                return view('list.inscriptions_list');
            } else {
               return view('list.inscriptions_list', compact('inscriptions'));
            }
        } else {
            return $inscriptions;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $days = Day::all();
        $schedules = Schedule::all();
        $class_day_schedule = ClassDaySchedule::all();

        foreach ($class_day_schedule as $key) {

            $classes = Classes::find($key->class_id);
            $activities = Activity::find($classes->activity_id);
            $classroom = Classroom::find($classes->classroom_id);
            $tutor = User::find($classes->user_id);

            $key->name = $activities->name . " - " . $classroom->name . " -  " . $tutor->name . " " . $tutor->last_name;


        }


        return view('inscriptions', compact('class_day_schedule', 'days', 'schedules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!empty($request->cds)){
            
            $saved = Inscription::where('user_id', $request->user_uid)->get();

            foreach ($saved as $key ) {
                $class_day_schedule = ClassDaySchedule::find($key->classes_days_schedules_id);
                $class_day_schedule->inscribed = $class_day_schedule->inscribed-1;
                $class_day_schedule->save();
                $key->delete();
            }

            foreach ($request->cds as $keyvalue) {

                $data = explode(",", $keyvalue);
                $inscriptions = new Inscription;
                $inscriptions->user_id = $request->user_uid;
                $inscriptions->classes_days_schedules_id = $data[0];
                $inscriptions->status = $request->status;
                $inscriptions->save();
                $class_day_schedule = ClassDaySchedule::find($inscriptions->classes_days_schedules_id);
                $class_day_schedule->inscribed = $class_day_schedule->inscribed+1;
                $class_day_schedule->save();
            }
        } else {
            
            $saved = Inscription::where('user_id', $request->user_uid)->get();

            foreach ($saved as $key ) {
                $class_day_schedule = ClassDaySchedule::find($key->classes_days_schedules_id);
                $class_day_schedule->inscribed = $class_day_schedule->inscribed-1;
                $class_day_schedule->save();
                $key->delete();
            }

        }        
  

        return redirect()->route('inscriptions.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $days = Day::all();
        $schedules = Schedule::all();
        $inscriptions = Inscription::find($id);
        $class_day_schedule = ClassDaySchedule::all();
        
        foreach ($class_day_schedule as $key) {

            $classes = Classes::find($key->class_id);
            $activities = Activity::find($classes->activity_id);
            $classroom = Classroom::find($classes->classroom_id);
            $tutor = User::find($classes->user_id);

            $key->name = $activities->name . " - " . $classroom->name . " -  " . $tutor->name . " " . $tutor->last_name;


        }
        $user = User::find($inscriptions->user_id);
        $inscriptions->user_name = $user->name . " " . $user->last_name . " - ". $user->email;

        return view('inscriptions', compact('inscriptions', 'class_day_schedule', 'days', 'schedules'));
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
        if(!empty($request->cds)){
            
            $saved = Inscription::where('user_id', $request->user_uid)->get();

            foreach ($saved as $key ) {
                $class_day_schedule = ClassDaySchedule::find($key->classes_days_schedules_id);
                $class_day_schedule->inscribed = $class_day_schedule->inscribed-1;
                $class_day_schedule->save();
                $key->delete();
            }

            foreach ($request->cds as $keyvalue) {

                $data = explode(",", $keyvalue);
                $inscriptions = new Inscription;
                $inscriptions->user_id = $request->user_uid;
                $inscriptions->classes_days_schedules_id = $data[0];
                $inscriptions->status = $request->status;
                $inscriptions->save();
                $class_day_schedule = ClassDaySchedule::find($inscriptions->classes_days_schedules_id);
                $class_day_schedule->inscribed = $class_day_schedule->inscribed+1;
                $class_day_schedule->save();
            }
        } else {
            
            $saved = Inscription::where('user_id', $request->user_uid)->get();

            foreach ($saved as $key ) {
                $class_day_schedule = ClassDaySchedule::find($key->classes_days_schedules_id);
                $class_day_schedule->inscribed = $class_day_schedule->inscribed-1;
                $class_day_schedule->save();
                $key->delete();
            }

        }        


        return redirect()->route('inscriptions.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inscriptions = Inscription::findOrFail($id);
        $inscriptions->delete();
        return redirect()->route('inscriptions.index');
    }

    public function autocomplete(){
        $term = Str::lower(Input::get('term'));
              
        $results = array();
        
        $queries = DB::table('users')
            ->where('name', 'LIKE', '%'.$term.'%')
            ->orWhere('last_name', 'LIKE', '%'.$term.'%')
            ->orWhere('email', 'LIKE', '%'.$term.'%')
            ->take(5)->get();
        
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->id, 'value' => $query->name . ' ' . $query->last_name . ' - ' . $query->email ];
        }

        return  $this->prepareResponse($results);
    }

    public function userInscriptions(){
        if($_GET['user_id']) {
            $inscriptions = Inscription::where('user_id', $_GET['user_id'])->get();
            foreach ($inscriptions as $keyvalue) {
                $class_day_schedule = ClassDaySchedule::find($keyvalue->classes_days_schedules_id);
                $classes = Classes::find($class_day_schedule->class_id);
                $activities = Activity::find($classes->activity_id);
                $tutor = User::find($classes->user_id);
                $class_day_schedule->activities = $activities;
                $class_day_schedule->tutor = $tutor;
                $class_day_schedule->classes = $classes;
                $keyvalue->classes_days_schedules = $class_day_schedule;
            }
            return $inscriptions;
        }
    }
}
