<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Inscription;
use App\ClassDaySchedule;
use Img;
use DB;
use Redirect;

class UsersController extends Controller
{


	function index(){
		 $users = User::whereHas('roles', function ($query) {
		            $query->where('name', '=', 'user');
		 })->get();

		 foreach ($users as $keyvalue) {
		 	unset($classesSchedules);
		 	$inscriptions = Inscription::where('user_id', $keyvalue->id)->get();
		 	foreach ($inscriptions as $key) {

		 		$classesSchedules[] = ClassDaySchedule::withClass(null)->where('classes_days_schedules.id', $key->classes_days_schedules_id)->first();
		 	}

		 	if(!empty($classesSchedules)){
		 		
		 		$keyvalue->classes = $classesSchedules;

		 	} 



		 }
        return view('list.users_all_list', compact('users'));		
	}


	function showAllUsers(){
		 $users = User::whereHas('roles', function ($query) {
		            $query->where('name', '=', 'user');
		 })->get();

		 foreach ($users as $keyvalue) {
		 	unset($classesSchedules);
		 	$inscriptions = Inscription::where('user_id', $keyvalue->id)->get();
		 	foreach ($inscriptions as $key) {

		 		$classesSchedules[] = ClassDaySchedule::withClass(null)->where('classes_days_schedules.id', $key->classes_days_schedules_id)->first();
		 	}

		 	if(!empty($classesSchedules)){
		 		
		 		$keyvalue->classes = $classesSchedules;

		 	} 



		 }
        return view('list.users_all_list', compact('users'));
	}

	function showInactiveUser(){

		 $users = DB::table('users AS t1')
					->select('t1.*')
					->leftJoin('inscriptions AS t2','t2.user_id','=','t1.id')
					->leftJoin('role_user AS t4','t4.user_id','=','t1.id')
					->leftJoin('roles AS t3','t3.id','=','t4.role_id')->where('t4.role_id', 2)
					->whereNull('t2.user_id')->get();
		 
		 if(!empty($users)){

        	return view('list.users_inactive_list', compact('users'));
		 } else {
        	return view('list.users_inactive_list');
		 }

	}

	function createRoles(){

		$roles = Role::all();

        return view('new_user', compact('roles'));

	}

	function create(){

        return view('new_user');

	}

	function store(Request $request){

		$user = new User;
		$user->name = $request->name;
		$user->last_name = $request->last_name;
		$user->document = $request->document;
		$user->phone_number = $request->phone_number;
		$user->address = $request->address;
		$user->autorizado = true;
		$user->email = $request->email;
		$user->password = bcrypt($user->last_name . $user->document);
		$user->genre = $request->genre;
		$user->birthdate = date('Y-m-d', strtotime($request->birthdate));
		if(!empty($request->medical_certificate)){
			$user->medical_certificate = $request->medical_certificate;
		}

		if(!empty($request->expiration_date)){
			$user->expiration_date = $request->expiration_date; 
		}

        if($request->file('file')) {
            $image = $request->file('file');
            $imageName = $request->file('file')->getClientOriginalName();
            $path_t = public_path('storage/profile/thumb_' . $imageName);
            $path = public_path('storage/profile/' . $imageName);
            Img::make($image->getRealPath())->resize(240,200)->save($path_t);
            Img::make($image->getRealPath())->save($path);
            $user->image = $imageName;
        }
		$user->save();

		if(!empty($request->role)){
			$role = Role::findOrFail($request->role);

		} else {
			$role = Role::where('name','=', 'user')->first();

		}

        $user->attachRole($role);
        
		$user->save();

        return redirect()->route('users.index');


	}

	function getByDni(Request $request){
		$document = $_GET['document'];
		$user = User::where('document', $document)->first();

        return $user;
	}
}
