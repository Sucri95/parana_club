<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\Category;
use Auth;
use Img;
use Validator;
use View;


class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
       public function index()
    {
        $news = News::all();
        if (Auth::check() && !Auth::user()->hasRole('user')) {
            if(!isset($news)){
                return view('list.news_list');
            } else {
               return view('list.news_list', compact('news'));
            }
        } else {
            
            return response(view('errors.404'), 404);

            //return $news;
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
        return view('news', compact('categories'));
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
            'content' => 'required ', 
            'status' => 'required | max:255', 
        ]); 

        if ($validator->fails()) {
            return redirect('news/create')
            ->withErrors($validator)
            ->withInput();
        }

        $news = new News;
        if($request->file('file')) {
            $image = $request->file('file');
            $imageName = $request->file('file')->getClientOriginalName();
            $path_t = public_path('storage/news/thumb_' . $imageName);
            $path = public_path('storage/news/' . $imageName);
            Img::make($image->getRealPath())->resize(240,200)->save($path_t);
            Img::make($image->getRealPath())->save($path);
            $news->image = $imageName;
        }
        if($request->important == true){
            $news->important = 1;
        } else {
            $news->important = 0;

        }
        $news->created_user_id = Auth::user()->id;
        $news->title = $request->title;
        $news->content = $request->content;
        $news->status = $request->status;
        $news->categories_id = $request->categories;
        $news->type = "text"; // CONTEMPLAR LUEGO OTROS TIPO DE CONTENIDO SLIDE O IFRAMES
        $news->save();

        return redirect()->route('news.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categories = Category::where('status', 'Activo')->get();
        return View::make('news')->with('news', News::find($id))->with('categories', $categories);
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
        $news = News::findOrFail($id);

        if($request->file('file')) {
            $image = $request->file('file');
            $imageName = $request->file('file')->getClientOriginalName();
            $path_t = public_path('storage/news/thumb_' . $imageName);
            $path = public_path('storage/news/' . $imageName);
            Img::make($image->getRealPath())->resize(240,200)->save($path_t);
            Img::make($image->getRealPath())->save($path);
            $news->image = $imageName;
        }
        
        $news->title = $request->title;
        $news->content = $request->content;
        $news->url = $request->url;
        $news->status = $request->status;
        $news->save();

        return redirect()->route('news.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();
        return redirect()->route('news.index');
    }
}
