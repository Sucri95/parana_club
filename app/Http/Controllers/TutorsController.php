<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use View;
use Img;
use App\Tutor;
use App\Role;
use App\User;
use App\Activity;
use App\Classes;
use App\ActivityByTutor;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Input;

class TutorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tutors = User::whereHas('roles', function ($query) {
                    $query->where('name', '=', 'tutor');
        })->get();

        foreach ($tutors as $keyvalue) {
            $classes = ActivityByTutor::with('activity')->where('user_id', $keyvalue->id)->get();
            $keyvalue->classes = $classes;
        }


       if (Auth::check()) {
            if(!isset($tutors)){
                return view('list.tutors_list');
            } else {
               return view('list.tutors_list', compact('tutors'));
            }
        } else {
            return $tutors;
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
        return view('tutors', compact('activities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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

        $role = Role::where('name','=', 'tutor')->first();

        $user->attachRole($role);
        
        $user->save();

        $activities = $request->qty;
        foreach($activities as $quan) {
            $activitybytutor = new ActivityByTutor;
            $activitybytutor->activity_id = $quan;
            $activitybytutor->user_id = $user->id;
            $string = "perc".$quan;
            $activitybytutor->percentage_gain = $request->$string;
            $activitybytutor->save();
        }


        return redirect()->route('tutors.index');

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

        $tutors = User::find($id);

        return view('tutors', compact('tutors', 'activities'));
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
            'name' => 'required | max:255 | unique:tutors,id,'.$id, 
            'last_name' => 'required | max:255 | unique:tutors,id,'.$id, 
            'email' => 'required | max:255 | unique:tutors,id,'.$id, 
        ]); 

        if ($validator->fails()) {
            return redirect('tutors/'.$id)
            ->withErrors($validator)
            ->withInput();
        }

        $tutors = User::findOrFail($id);

        if($request->file('file')) {
            $image = $request->file('file');
            $imageName = $request->file('file')->getClientOriginalName();
            $path_t = public_path('storage/thumb_' . $imageName);
            $path = public_path('storage/' . $imageName);
            Img::make($image->getRealPath())->resize(240,200)->save($path_t);
            Img::make($image->getRealPath())->save($path);
            $tutors->image = $imageName;
        }
        
        $activitybytutordata = ActivityByTutor::where('user_id', $id)->get();

        foreach ($activitybytutordata as $key) {
            $activityt = ActivityByTutor::find($key->id);
            $activityt->delete();
        }

        
        $activities = $request->qty;
        foreach($activities as $quan) {
            $activitybytutor = new ActivityByTutor;
            $activitybytutor->activity_id = $quan;
            $activitybytutor->user_id = $id;
            $string = "perc".$quan;
            $activitybytutor->percentage_gain = $request->$string;
            $activitybytutor->save();
        }

        $tutors->name = $request->name;
        $tutors->last_name = $request->last_name;
        $tutors->document = $request->document;
        $tutors->phone_number = $request->phone_number;
        $tutors->address = $request->address;
        $tutors->email = $request->email;
        $tutors->password = bcrypt($user->last_name . $user->document);
        $tutors->genre = $request->genre;
        $tutors->birthdate = date('Y-m-d', strtotime($request->birthdate));
        $tutors->save();

        return redirect()->route('tutors.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tutors = Tutor::findOrFail($id);
        $tutors->delete();
        return redirect()->route('tutors.index');
    }

    public function activitiesByTutor(){
        
        if(!empty($_GET['tutor_id'])) {
            //TO TUTOR GET ACTIVITES
            $activitybytutor = ActivityByTutor::where('user_id', $_GET['tutor_id'])->get();
            foreach ($activitybytutor as $keyvalue) {
                $activity = Activity::findOrFail($keyvalue->activity_id);
                $keyvalue->activity_name = $activity->name;
            }


            return $activitybytutor;

        } else if(!empty($_GET['activity_id'])){
            //TO CLASSES GET TUTORS
            $activitybytutor = ActivityByTutor::where('activity_id', $_GET['activity_id'])->get();
            foreach ($activitybytutor as $keyvalue) {
                $tutor = User::findOrFail($keyvalue->user_id);
                $keyvalue->tutor_name = $tutor->name . " " . $tutor->last_name;

            }

            return $activitybytutor;

        }

    }

    public function autocomplete(){
        $term = Str::lower(Input::get('term'));
        $activity_id = $_GET['activity_id'];
              
        $results = array();
        
        $queries = DB::table('activities_by_tutors')
            ->join('users', 'users.id', '=', 'activities_by_tutors.user_id')
            ->where(function ($query )  use ($activity_id) {
                $query->where('activities_by_tutors.activity_id', '=', $activity_id);
            })->where(function ($query) use ($term) {
                $query->where('users.name', 'LIKE', '%'.$term.'%')
                      ->orWhere('users.last_name', 'LIKE', '%'.$term.'%');
            })->take(5)->get();
        
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->id, 'value' => $query->name . " " .  $query->last_name];
        }
        return  $this->prepareResponse($results);
    }
}
