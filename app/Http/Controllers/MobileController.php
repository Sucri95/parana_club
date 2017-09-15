<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Benchmark;
use App\User;
use App\Classes;
use App\Activity;
use App\Classroom;
use App\Day;
use App\Schedule;
use App\Inscription;
use App\Notifications;
use App\ClassDaySchedule;
use App\Wod;
use DB;
use Auth;
use View;

class MobileController extends Controller
{
	public function getNotificationsByUser(){
		if(!empty($_GET['user'])){
			$user = $_GET['user'];
			$notifications = Notifications::where('user_id',$user)->where('status', 'Activo')->get();
			return $notifications;
		}
	}

	/*Login Service*/
	//Route: mobile/login_service
	public function loginService(Request $request)
    {

        $user = DB::table('users')->where('email', $request->email)->first();

        if (is_null($user)) {

        	return "No se encuentra registrado";

        } else {
	        $userdata = array(
	            'email' => $request->email,
	            'password' => $request->emaipasswordl
	             );

	       
	        if(Auth::attempt($userdata)){
	        	return $user;

	        }else{

	        	return "Datos incorrectos";

	        }        	
        }
 
    }

    /*Mostrar ejercicios*/
    /*Route: mobile/show_work_outs*/

    public function showWorkOuts(Request $request)
    {

    	$wod = Wod::where('show_on', date('Y-m-d'))->where('status', 'Activo')->get();

    	return $wod;
    	
    }

    /*Mostrar benchmarks*/
    /*Route: mobile/show_benchmarks*/

    public function showBenchmarks(Request $request)
    {

    	$benchmarks = Benchmark::all();

    	return $benchmarks;
    	
    }

    /*Mostrar historial de actividades*/
    /*Route: mobile/show_activity_historial*/

    public function showActivityHistorial(Request $request)
    {
    	$user = $request->user_id;
    	$inscriptions = Inscription::where('user_id', $user)->get();

    	$response = array();
    	$count = 0;


        foreach ($inscriptions as $key ) {

            $classes_days_schedules = ClassDaySchedule::find($key->classes_days_schedules_id);
            $date = Schedule::find($classes_days_schedules->schedule_start_id);
            $day = Day::find($classes_days_schedules->day_id);
            $classes = Classes::find($classes_days_schedules->class_id);
            $activities = Activity::find($classes->activity_id);
            $classroom = Classroom::find($classes->classroom_id);
            $user = User::find($user);

            $response[$count]['date'] = $date->description;
            $response[$count]['day']  = $day->name;
            $response[$count]['activity_name']  = $activities->name;

            $count++;
        }

        return $response;		
    	
    }
}
