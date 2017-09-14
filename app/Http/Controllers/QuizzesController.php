<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quizzes;
use App\Category;
use App\QuizzesOptions;
use Auth;

class QuizzesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizzes = Quizzes::all();

        foreach ($quizzes as $keyvalue) {
            $categories = Category::findOrFail($keyvalue->categories_id);
            $keyvalue->categories_name = $categories->name;
            if($keyvalue->answer == 1){
                $quizzes_options = QuizzesOptions::where('answer', 1)->where('quizzes_id', $keyvalue->id)->first();
                $keyvalue->answer_option = $quizzes_options->option;
            }
        }
        //$quizzes = Quizzes::withAnswer()->get(); LOS QUIZZ CON RESPUESTAS CORRECTAS
        if (Auth::check()) {
            if(!isset($quizzes)){
                return view('list.quizzes_list');
            } else {
               return view('list.quizzes_list', compact('quizzes'));
            }
        } else {
            return $quizzes;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status', 'Activo')->get();
        return view('quizzes', compact('categories'));
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
        ]); 

        $validator = Validator::make($request->all(), [
            'name' => 'required | max:255 | unique:quizzes', 
            'cost' => 'required | integer', 
            'stock_inicial' => 'required | integer',
        ]); 

        if ($validator->fails()) {
            return redirect('quizzes/create')
            ->withErrors($validator)
            ->withInput();
        }*/

        $quizzes = new Quizzes;
        $quizzes->categories_id = $request->categories;
        $quizzes->question = $request->question;
        $quizzes->status = $request->status;
        if($request->answer == true){
            $quizzes->answer = 1;
            $quizzes->save();
            $quizzes_options = new QuizzesOptions;
            $quizzes_options->quizzes_id = $quizzes->id; 
            $quizzes_options->answer = 1;
            $quizzes_options->option = $request->answer_option;
            $quizzes_options->save();
        } else {
            $quizzes->answer = 0;
            $quizzes->save();
        }
        
        foreach ($request->option as $keyvalue) {
            $quizzes_options = new QuizzesOptions;
            $quizzes_options->quizzes_id = $quizzes->id; 
            $quizzes_options->answer = 0;
            $quizzes_options->option = $keyvalue;
            $quizzes_options->save();
        }


        return redirect()->route('quizzes.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $quizzes = Quizzes::find($id);
        $categories = Category::where('status', 'Activo')->get();

        if($quizzes->answer == 1){
            $quizzes_options = QuizzesOptions::where('answer', 1)->where('quizzes_id', $quizzes->id)->first();
            $quizzes->answer_id = $quizzes_options->id;
            $quizzes->answer_option = $quizzes_options->option;
        }

        $quizzes->options = QuizzesOptions::where('answer', 0)->where('quizzes_id', $quizzes->id)->get();

        return view('quizzes', compact('quizzes', 'categories'));
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

    /*    $validator = Validator::make($request->all(), [
            'name' => 'required | max:255 | unique:quizzes,id,'.$id, 
            'cost' => 'required | integer', 
            'stock_inicial' => 'required | integer',
        ]); 

        if ($validator->fails()) {
            return redirect('quizzes/'.$id)
            ->withErrors($validator)
            ->withInput();
        }*/
        $quizzes = Quizzes::findOrFail($id);

        $quizzes->categories_id = $request->categories;
        $quizzes->question = $request->question;
        $quizzes->status = $request->status;
        if($quizzes->answer == 1  && $request->answer == true){ 

            $quizzes_options = QuizzesOptions::findOrFail($request->answer_id);
            $quizzes_options->option = $request->answer_option;
            $quizzes_options->save();

        } else if($quizzes->answer == 1  && $request->answer == false){
            $quizzes->answer = 0;
            $quizzes_options = QuizzesOptions::findOrFail($request->answer_id);
            $quizzes_options->delete();

        } else if($quizzes->answer == 0  && $request->answer == true){
            $quizzes->answer = 1;
            $quizzes_options = new QuizzesOptions;
            $quizzes_options->quizzes_id = $quizzes->id; 
            $quizzes_options->answer = 1;
            $quizzes_options->option = $request->answer_option;
            $quizzes_options->save();
        } else if($quizzes->answer == 0  && $request->answer == false){

        }
        
        $quizzes->save();
        if(!empty($request->ids)){
            foreach ($request->ids as $keyvalue) {
                $string = "option-".$keyvalue; 
                $quizzes_options = QuizzesOptions::findOrFail($keyvalue);
                $quizzes_options->option = $request->$string;
                $quizzes_options->save();

            }
        }
        
        if(!empty($request->option)){
            foreach ($request->option as $keyvalue) {
                $quizzes_options = new QuizzesOptions;
                $quizzes_options->quizzes_id = $quizzes->id; 
                $quizzes_options->answer = 0;
                $quizzes_options->option = $keyvalue;
                $quizzes_options->save();
            }        
        }
    

        return redirect()->route('quizzes.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quizzes = Quizzes::findOrFail($id);
        $quizzes->delete();
        return redirect()->route('quizzes.index');
    }
}
