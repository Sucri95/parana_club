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
use App\NotificationsUsers;
use App\ClassDaySchedule;
use App\Wod;
use Mail;
use DB;
use Auth;
use View;
use Hash;


class MobileController extends Controller
{

    /*Get user notifications*/
    //Route: mobile/get_notifications_by_user
	public function getNotificationsByUser()
    {

        $user = $_GET['user'];
        $response = array();
        $count = 0;

		if(!empty($user)){

			$searchnotifications = NotificationsUsers::where('user_id', $user)->get();

            foreach ($searchnotifications as $search) {

                $not = Notifications::where('id', $search->notifications_id)->first();
                $response[$count]['id'] = $not->id;
                $response[$count]['title'] = $not->title;
                $response[$count]['message'] = $not->message;
                $response[$count]['image'] = $not->image;
                $response[$count]['url'] = $not->url;
                $count++;
            }
			return $response;
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

    /*Enviar link para recuperar la contraseña*/
    //Route: mobile/send_link_reset_passw
    public function sendLinkResetPassw(Request $request)
    {

        $user = User::findOrFail($request->user_id);

        $topica['especificaciones'] = Hash::make($user->email);
            
        $data = ['user' => $user, 'topica' => $topica];

            if(filter_var($user->email, FILTER_VALIDATE_EMAIL)){

                Mail::send('reset_password', $data, function($message) use ($topica, $user)
                    {
                        $message->to($user->email)->subject('Paraná Club - Recuperar Contraseña');
                    });
    
            }
        
        return $data;
    }

    /*Recuperar la contraseña*/
    //Route: mobile/reset_password
    public function resetPassword()
    {
        $token = $_GET['token'];

        $id = $_GET['id'];

        $user = User::find($id);
        $password = Hash::check($user->email, $token);

        if ($password == true) {

            return "Mostrar vista";

       }
   }    

    /*Logout Service*/
    //Route: mobile/logout_service
    public function logout()
    {
        Auth::logout();
        return "Logout";
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
    	$inscriptions = Inscription::where('user_id', $user)->where('status', 'Activo')->get();

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

    /*Reservar turno*/
    /*Route: mobile/book_turns*/

    public function bookTurns(Request $request)
    {

        $response = array();
        $count = 0;


        $hour = $request->hour;
        $date = $request->date;
        $user = $request->user_id;
        $activity = Activity::findOrFail(1);
        $classes = Classes::where('activity_id', $activity->id)->get();

        $response['hora'] = $hour; 
        $response['date'] = $date; 
        $response['activity'] = $activity->name;
        $response['classes']  = $classes;

        foreach ($classes as $class) {

            $scheduled_classes = ClassDaySchedule::where('class_id', $class->id)->get();
            
            foreach ($scheduled_classes as $cds) {

                $schedule_start_hour = Schedule::findOrFail($cds->schedule_start_id);
                $schedule_end_hour   = Schedule::findOrFail($cds->schedule_end_id);

                /*$response['schedule_start_hour'][$count] = $schedule_start_hour->description;
                $response['schedule_end_hour'][$count] = $schedule_end_hour->description;*/

                if ($cds->inscribed <= $class->capacity && strtotime($class->start_date) <= strtotime($date) && strtotime($date) <= strtotime($class->end_date) && strtotime($schedule_start_hour->description) <= strtotime($hour) && strtotime($hour) < strtotime($schedule_end_hour->description))
                {

                    $inscriptions = new Inscription;
                    $inscriptions->user_id = $user;
                    $inscriptions->classes_days_schedules_id = $cds->id;
                    $inscriptions->status = "Activo";
                    $inscriptions->save();
                    $cds->inscribed = $cds->inscribed+1;
                    $cds->save();
                    $response['inscription'] = $inscriptions;
                    $response['scheduled_classes'][$count] = $cds;
                    $response['book_shift'] = 'Yes';

                }else{

                    $response['book_shift'] = 'No';

                }

                $count++;
            }

        }


        return $response; 
        
    }

    /*Cancelar turno*/
    /*Route: mobile/cancel_turns*/

    public function cancelTurns(Request $request)
    {

        $response = array();
        $count = 0;


        $hour = $request->hour;
        $date = $request->date;
        $user = $request->user_id;
        $inscription = Inscription::where('user_id', $user)->get();

        foreach ($inscription as $ins) {

            $scheduled_classes = ClassDaySchedule::where('id', $ins->classes_days_schedules_id)->get();
            
            foreach ($scheduled_classes as $cds) {

                $schedule_start_hour = Schedule::findOrFail($cds->schedule_start_id);
                $schedule_end_hour   = Schedule::findOrFail($cds->schedule_end_id);
                
                if (strtotime($schedule_start_hour->description) <= strtotime($hour) && strtotime($hour) < strtotime($schedule_end_hour->description)) 
                {

                    $cds->inscribed = $cds->inscribed-1;
                    $cds->save();
                    $ins->status = 'Cancelado';
                    $ins->save();
                    $response['class']  = "Crossfit";
                    $response['hour']   = $hour;
                    $response['date']   = $date;
                    $response['status'] = $ins->status;
                }
            }
        }

      
        return $response; 
        
    }
}
