@extends('layouts.app')

@section('content')
@if(Auth::check() && Auth::user()->hasRole('admin'))
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Wod</div>

                <div class="panel-body">

                            @if ( ! empty($wods['description']))
                            {{ Form::model($wods, array('route' => array('wods.update', $wods->id), 'method' => 'PUT')) }}

                            @else
                            {!! Form::open(['route' => 'wods.store', 'method' => 'POST', 'files' => 'true']) !!}
                            @endif

                    {{ csrf_field() }}

                    <div class="col-md-12 form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                        <label for="title" >Título </label>
                            @if ( ! empty($wods['title']))
                                <input id="title" type="text" class="form-control" name="title" value="{{ $wods['title'] }}" placeholder="Ingrese el título del wod...">
                            @else
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Ingrese el título del wod...">
                            @endif

                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div id="div-description" class="col-md-12 form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" >Contenido</label>


                            @if ( ! empty($wods['description']))
                            <textarea class="ckeditor" name="description" id="description" rows="10" cols="80"> {{ $wods['description'] }} </textarea>
                            @else
                            <textarea class="ckeditor" name="description" id="description" rows="10" cols="80" value="{{  old('description') }}"></textarea>
                            @endif

                            @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                            @endif
                    </div>

                    <div class="col-md-12 form-group">
                        <label for="show_on">Mostrar el </label>
                        <div class="input-group">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                            @if ( ! empty($wods['show_on']))
                                <input class="form-control datepicker" name="show_on" id="show_on" type="text" placeholder="Ingrese la fecha para mostrar el wod..." value="{{ $wods['show_on'] }}">
                            @else
                                <input class="form-control datepicker" name="show_on" id="show_on" type="text" placeholder="Ingrese la fecha para mostrar el wod...">
                            @endif


                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="status">Estatus</label>


                            @if ( ! empty($wods['status']))
                            <select id="status" class="selectpicker form-control" name="status">
                                @if ( $wods['status'] == "Activo")
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

