@extends('layouts.app')

@section('content')
@if(Auth::check() && Auth::user()->hasRole('admin'))

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Notificaciones</div>

                <div class="panel-body">

                    @if ( ! empty($notifications['title']))
                    {{ Form::model($notifications, array('route' => array('notifications.update', $notifications->id), 'method' => 'PUT')) }}

                    @else
                    {!! Form::open(['route' => 'notifications.store', 'method' => 'POST', 'files' => 'true']) !!}
                    @endif

                    {{ csrf_field() }}

                    <div class="col-md-12 form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                        <label for="title">Titulo</label>
                            @if ( ! empty($notifications['title']))
                            <input id="title" type="text" class="form-control" name="title" value="{{ $notifications['title'] }}">
                            @else
                            <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}">
                            @endif

                        @if ($errors->has('title'))
                        <span class="help-block">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                        <label for="message">Mensaje</label>
                            @if ( ! empty($notifications['message']))
                            <input id="message" type="text" class="form-control" name="message" value="{{ $notifications['message'] }}">
                            @else
                            <input id="message" type="text" class="form-control" name="message" value="{{ old('message') }}">
                            @endif

                        @if ($errors->has('message'))
                        <span class="help-block">
                            <strong>{{ $errors->first('message') }}</strong>
                        </span>
                        @endif
                    </div>


                    <div class="col-md-12 form-group{{ $errors->has('file') ? ' has-error' : '' }} no-margin-bottom">
                        <label for="file">Imagen</label>                      

                        
                        <div class="margin-left">
                            <input type="file" name="file" class="filestyle">
                        </div>

                            @if ($errors->has('file'))
                            <span class="col-md-12 help-block">
                                <strong>{{ $errors->first('file') }}</strong>
                            </span>
                            @endif
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                        <label for="url">Url redirect imagen</label>
                            @if ( ! empty($notifications['url']))
                            <input id="url" type="text" class="form-control" name="url" value="{{ $notifications['url'] }}">
                            @else
                            <input id="url" type="text" class="form-control" name="url" value="{{ old('url') }}">
                            @endif

                        @if ($errors->has('url'))
                        <span class="help-block">
                            <strong>{{ $errors->first('url') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group col-md-12">
                        <label for="status" >Estatus</label>

                            @if ( ! empty($notifications['status']))
                            <select id="status" class="selectpicker form-control" name="status">
                                @if ( $notifications['status'] == "Activo")
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

