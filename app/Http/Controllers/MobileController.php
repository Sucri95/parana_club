<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MobileController extends Controller
{
	public function getNotificationsByUser(){
		if(!empty($_GET['user'])){
			$user = $_GET['user'];
			$notifications = notifications::where('user_id',$user)->where('status', 'Activo')->get();
			return $notifications;
		}
	}

	public function loginService(Request $request)
    {

        $user = DB::table('users')->where('email', Request::get('email'))->first();

        if (is_null($user)) {

        	header("Content-Type: application/json", true);
        	$response = "msg2";
            echo json_encode($response);
        } else {
	        $userdata = array(
	            'email' => Request::get('email'),
	            'password' => Request::get('password')
	             );

	       
	        if(Auth::attempt($userdata)){
	        	header("Content-Type: application/json", true);
	            echo json_encode($user);

	        }else{

	        	header("Content-Type: application/json", true);
	        	$response = "msg1";
	            echo json_encode($response);

	        }        	
        }
 
    }
}
