<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Notifications;
use App\NotificationsUsers;
use App\User;
use App\Role;
use View;
use Img;
use Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Validator;



class NotificationsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Notifications::all();
        if (Auth::check() && !Auth::user()->hasRole('user')) {
            if(!isset($notifications)){
                return view('list.notifications_list');
            } else {
               return view('list.notifications_list', compact('notifications'));
            }
        } else {
            
            return response(view('errors.404'), 404);

            //return $notifications;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notifications');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required | max:255', 
            'message' => 'required ', 
            'status' => 'required | max:255', 
        ]); 

        if ($validator->fails()) {
            return redirect('notifications/create')
            ->withErrors($validator)
            ->withInput();
        }

        $notifications = new Notifications;
        if($request->file('file')) {
            $image = $request->file('file');
            $imageName = $request->file('file')->getClientOriginalName();
            $path_t = public_path('storage/notifications/thumb_' . $imageName);
            $path = public_path('storage/notifications/' . $imageName);
            Img::make($image->getRealPath())->resize(240,200)->save($path_t);
            Img::make($image->getRealPath())->save($path);
            $notifications->image = $imageName;
        }
        $notifications->title = $request->title;
        $notifications->message = $request->message;
        $notifications->url = $request->url;
        $notifications->status = $request->status;
        $notifications->save();

        return redirect()->route('notifications.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return View::make('notifications')->with('notifications', Notifications::find($id));
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
        $notifications = Notifications::findOrFail($id);

        if($request->file('file')) {
            $image = $request->file('file');
            $imageName = $request->file('file')->getClientOriginalName();
            $path_t = public_path('storage/notifications/thumb_' . $imageName);
            $path = public_path('storage/notifications/' . $imageName);
            Img::make($image->getRealPath())->resize(240,200)->save($path_t);
            Img::make($image->getRealPath())->save($path);
            $notifications->image = $imageName;
        }
        
        $notifications->title = $request->title;
        $notifications->message = $request->message;
        $notifications->url = $request->url;
        $notifications->status = $request->status;
        $notifications->save();

        return redirect()->route('notifications.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notifications = Notifications::findOrFail($id);
        $notifications->delete();
        return redirect()->route('notifications.index');
    }


    public function consultarUsuarios(Request $request, $id)
    {
        dd($request);
        $seleccionados = $request->seleccionados;
        if(!empty($request->nombre))
        {
            $value = $request->nombre;
            $usuarios = User::where(function ($query) use ($value) {
                $query->where('name', 'LIKE','%'. $value .'%')
                      ->orWhere('apellido', 'LIKE','%' . $value .'%')
                      ->orWhere('email', 'LIKE','%' . $value .'%');
            })->where(function ($query) use ($value) {
                $query->whereNull('username')
                      ->whereNull('bigpromo')
                      ->whereNull('status');
            })->get();
            if(!empty($usuarios))
            {
                $not_found = false;
                return view('list.notifications_user_list', compact('id', 'usuarios','not_found', 'seleccionados'));
            } else {
                $not_found = true;
                return view('list.notifications_user_list', compact('id', 'not_found', 'seleccionados'));
            }

        }
    }


    public function notificationsUsers($id)
    {

        $usuarios_data = User::all();

        foreach ($usuarios_data as $keyvalue) {
            $notificacion = NotificationsUsers::where('notifications_id', $id)->where('user_id', $keyvalue->id)->get();
                if(count($notificacion) > 0){

                } else {
                    $usuarios[] = $keyvalue;
                    
                }
        }


        $total = count($usuarios);
        $notifications_usuarios = NotificationsUsers::where('notifications_id', $id)->get();
        foreach ($notifications_usuarios as $key ) {
            if(!empty($seleccionados) && in_array($key->user_id, $seleccionados)) {

            } else {
                $seleccionados[] = $key->user_id;
            }
        }

        if(!isset($seleccionados)) {

            return view('list.notifications_user_list', compact('id', 'usuarios', 'total'));

        } else {
            return view('list.notifications_user_list', compact('id', 'usuarios', 'seleccionados', 'total'));

        }

    }


    public function saveNotificationsUsers(Request $request, $id)
    {
        if(count($request->seleccionados) > 0) {
            foreach ($request->seleccionados as $keyvalue) {
                $validate = NotificationsUsers::where('user_id', $keyvalue)->where('notifications_id', $id)->get();
                if (count($validate) > 0){

                } else {
                    $notifications_usuarios = new NotificationsUsers;
                    $notifications_usuarios->user_id = $keyvalue;
                    $notifications_usuarios->notifications_id = $id;
                    $notifications_usuarios->status = 'Pendiente';
                    $notifications_usuarios->save();                    
                }

            }
            return redirect()->route('notifications.index');

        } else {
                $notifications_usuarios = NotificationsUsers::where('notifications_id', $id)->get();
                foreach ($notifications_usuarios as $item) {
                    $item->delete();
                }

                return redirect()->route('notifications.index');

        }


    }
}
