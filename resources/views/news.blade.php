@extends('layouts.app')

@section('content')
@if(Auth::check() && Auth::user()->hasRole('admin'))
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Novedades</div>

                <div class="panel-body">

                            @if ( ! empty($news['title']))
                            {{ Form::model($news, array('route' => array('news.update', $news->id), 'method' => 'PUT')) }}

                            @else
                            {!! Form::open(['route' => 'news.store', 'method' => 'POST', 'files' => 'true']) !!}
                            @endif

                    {{ csrf_field() }}

                    <div class="col-md-12 form-group">
                        <label for="categories">Categoría</label>
                            <select class="form-control" name="categories" id="categories">

                                    @if ( !empty($categories))

                                        @foreach($categories as $item)
                                            @if ( ! empty($news['categories_id']))
                                            <option value="{{$item->id}}"  @if($news['categories_id'] == $item->id) selected @endif >{{$item->name}}</option>
                                            @else
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endif
                                        @endforeach

                                    @endif
                                    
                            </select>
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                        <label for="title" >Título </label>
                            @if ( ! empty($news['title']))
                                <input id="title" type="text" class="form-control" name="title" value="{{ $news['title'] }}">
                            @else
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}">
                            @endif

                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div id="div-content" class="col-md-12 form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                        <label for="content" >Contenido</label>


                            @if ( ! empty($news['content']))
                            <textarea class="ckeditor" name="content" id="content" rows="10" cols="80"> {{ $news['content'] }} </textarea>
                            @else
                            <textarea class="ckeditor" name="content" id="content" rows="10" cols="80" value="{{  old('content') }}"></textarea>
                            @endif

                            @if ($errors->has('content'))
                            <span class="help-block">
                                <strong>{{ $errors->first('content') }}</strong>
                            </span>
                            @endif
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('file') ? ' has-error' : '' }} no-margin-bottom">
                        <label for="file">Imagen</label>                      

                        @if ( ! empty($news['image']))
                        <div class="col-md-6">
                            <div class="thumbnail">
                                <img src="../storage/news/thumb_{{$news['image']}}">
                            </div>
                        </div>
                        @endif
                        
                        <div class="margin-left">
                            <input type="file" name="file" >
                        </div>

                            @if ($errors->has('file'))
                            <span class="col-md-12 help-block">
                                <strong>{{ $errors->first('file') }}</strong>
                            </span>
                            @endif
                    </div>

                    <div class="form-group col-md-12">
                        <label for="status">Estatus</label>


                            @if ( ! empty($news['status']))
                            <select id="status" class="selectpicker form-control" name="status">
                                @if ( $news['status'] == "Activo")
                                <option value="Activo" selected="selected">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                                @else
                                <option value="Activo">Activo</option>
                                <option value="Inactivo" selected="selected">Inactivo</option>
                                @endif

                            </select>
                            @else
                            <select id="status" class="selectpicker form-control" name="status">
                                <option>Seleccione</option>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                            @endif
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('important') ? ' has-error' : '' }}">
                        <label for="important" class="col-md-4 control-label">¿Desea destacar este news?</label>

                            @if ( ! empty($news['important']) && $news['important'] == true)
                                <input checked data-toggle="toggle" type="checkbox" name="important" id="important" data-on="Si" data-off="No">
                            @else
                                <input data-toggle="toggle" type="checkbox" name="important" id="important" data-on="Si" data-off="No">
                            @endif

                        @if ($errors->has('important'))
                            <span class="help-block">
                                <strong>{{ $errors->first('important') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-2 form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Página no encontrada</div>

                <div class="panel-body">
                    Verifique que ha escrito bien la dirección de enlace. 
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

