<?php

namespace App\Http\Controllers;
use Auth;
use Validator;
use View;
use Img;
use App\Tasks;
use App\User;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = DB::table('tasks')
                 ->groupBy('code')
                 ->get();

        foreach ($tasks as $keyvalue) {
        	$user = User::find($keyvalue->responsable_user_id);
        	$keyvalue->responsable = $user->name . " " . $user->last_name;
        }
        if (Auth::check()) {
            if(!isset($tasks)){
                return view('list.tasks_list');
            } else {
               return view('list.tasks_list', compact('tasks'));
            }
        } else {
            return $tasks;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$users = User::whereHas('roles', function ($query) {
		            $query->where('name', '=', 'employee');
		})->get();

		
		if(isset($users)){
        	return view('tasks', compact('users') );

		} else {

        	return view('tasks');
		}

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
            'description' => 'required | max:255'
        ]); 

        if ($validator->fails()) {
            return redirect('tasks/create')
            ->withErrors($validator)
            ->withInput();
        }

        $string = str_random(4);

        
        if($request->all_employees == true){

            $users = User::whereHas('roles', function ($query) {
                        $query->where('name', '=', 'employee');
             })->get();

            foreach ($users as $keyvalue) {
                $tasks = new Tasks;
                $tasks->all_employees = 1;
                $tasks->description = $request->description;
                $tasks->user_id = Auth::user()->id;
                $tasks->responsable_user_id = $keyvalue->id;
                $tasks->code = $string;

                if($request->all_days == true){
                    $tasks->all_days = 1;

                } else{
                    $tasks->all_days = 0;

                    if(!empty($request->show_on)){
                        $tasks->show_on = date('Y-m-d', strtotime($request->show_on));
                    }

                }
                $tasks->status = $request->status;
                $tasks->save();
            }


        } else{

            $tasks = new Tasks;
            $tasks->description = $request->description;
            $tasks->user_id = Auth::user()->id;
            $tasks->responsable_user_id = $request->responsable_user_id;
            $tasks->all_employees = 0;
            $tasks->code = $string;
            if($request->all_days == true){
                $tasks->all_days = 1;
            } else{
                $tasks->all_days = 0;

                if(!empty($request->show_on)){
                    $tasks->show_on = date('Y-m-d', strtotime($request->show_on));
                }

            }
            
            $tasks->status = $request->status;
            $tasks->save();

        }




        return redirect()->route('tasks.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $tasks = Tasks::find($id);
        $users = User::whereHas('roles', function ($query) {
		            $query->where('name', '=', 'employee');
		})->get();

		
		if(isset($users)){
        	return view('tasks', compact('tasks', 'users'));
		} else {
        	return view('tasks', compact('tasks'));

		}
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
            'description' => 'required | max:255 '
        ]); 

        if ($validator->fails()) {
            return redirect('tasks/'.$id)
            ->withErrors($validator)
            ->withInput();
        }

        $tasks = Tasks::findOrFail($id);

        if($tasks->all_employees == 1 && $request->all_employees == true){

            $all_tasks = Tasks::where('code', $tasks->code)->get();
            foreach ($all_tasks as $keyvalue) {
                $keyvalue->description = $request->description;
                $keyvalue->status = $request->status;
                if($request->all_days == true){
                    
                    $keyvalue->all_days = 1;

                } else{
                    
                    $keyvalue->all_days = 0;

                    if(!empty($request->show_on)){
                        $keyvalue->show_on = date('Y-m-d', strtotime($request->show_on));
                    }

                }
                $keyvalue->save();

            }

        } else if ($tasks->all_employees == 0 && $request->all_employees == true){

            $tasks->description = $request->description;
            $tasks->status = $request->status;
            $tasks->all_employees = 1;
            if($request->all_days == true){
                
                $tasks->all_days = 1;

            } else{
                
                $tasks->all_days = 0;

                if(!empty($request->show_on)){
                    $tasks->show_on = date('Y-m-d', strtotime($request->show_on));
                }

            }
            $tasks->save();

            $users = User::whereHas('roles', function ($query) {
                        $query->where('name', '=', 'employee');
             })->get();

            foreach ($users as $keyvalue) {
                if($keyvalue->id != $tasks->responsable_user_id){
                    $tasks_new = new Tasks;
                    $tasks_new->all_employees = 1;
                    $tasks_new->description = $request->description;
                    $tasks_new->user_id = Auth::user()->id;
                    $tasks_new->responsable_user_id = $keyvalue->id;
                    $tasks_new->code = $tasks->code;

                    if($request->all_days == true){
                        $tasks_new->all_days = 1;

                    } else{
                        $tasks_new->all_days = 0;

                        if(!empty($request->show_on)){
                            $tasks_new->show_on = date('Y-m-d', strtotime($request->show_on));
                        }

                    }
                    $tasks_new->status = $request->status;
                    $tasks_new->save();                
                }
    
            }

        } else if ($tasks->all_employees == 1 && $request->all_employees == false){

            $all_tasks = Tasks::where('code', $tasks->code)->get();
            foreach ($all_tasks as $keyvalue) {
                if($keyvalue->id != $tasks->id){
                    $keyvalue->delete(); //VER RELACION CON TASKBYUSER implementar un historial NO SE 
                } else {
                    $tasks->all_employees = 0;
                    $tasks->description = $request->description;
                    $tasks->user_id = Auth::user()->id;
                    $tasks->responsable_user_id = $request->responsable_user_id;

                    if($request->all_days == true){
                        $tasks->all_days = 1;

                    } else{
                        $tasks->all_days = 0;
                        if(!empty($request->show_on)){
                            $tasks->show_on = date('Y-m-d', strtotime($request->show_on));
                        }

                    }

                    $tasks->status = $request->status;
                    $tasks->save();    
                }
            }

        } else if($tasks->all_employees == 0 && $request->all_employees == false){
            $tasks->description = $request->description;
            $tasks->user_id = Auth::user()->id;
            $tasks->responsable_user_id = $request->responsable_user_id;
    
            if($request->all_days == true){
                $tasks->all_days = 1;

            } else{
                $tasks->all_days = 0;
                if(!empty($request->show_on)){
                    $tasks->show_on = date('Y-m-d', strtotime($request->show_on));
                }
            }
            $tasks->status = $request->status;
            $tasks->save();            
        }


        return redirect()->route('tasks.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tasks = Tasks::findOrFail($id);
        $tasks->delete();
        return redirect()->route('tasks.index');
    }

    public function autocomplete(){
        $term = Str::lower(Input::get('term'));
              
        $results = array();
        
        $queries = DB::table('tasks')
            ->where('name', 'LIKE', '%'.$term.'%')
            ->take(5)->get();
        
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->id, 'value' => $query->name, 'price' => $query->cost ];
        }

        return  $this->prepareResponse($results);
    }

}
