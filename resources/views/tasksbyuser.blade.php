@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Tareas</div>

                <div class="panel-body">

                            @if ( ! empty($tasks['description']))
                            {{ Form::model($tasks, array('route' => array('tasks.update', $tasks->id), 'method' => 'PUT')) }}

                            @else
                            {!! Form::open(['route' => 'tasks.store', 'method' => 'POST', 'files' => 'true']) !!}
                            @endif

                    {{ csrf_field() }}



                    <div class="col-md-12 form-group{{ $errors->has('all_days') ? ' has-error' : '' }}">
                        <label for="all_days" class="col-md-4 control-label">¿Mostrar todos los días?</label>

                            @if ( ! empty($tasks['all_days']) && $tasks['all_days'] == true)
                                <input checked data-toggle="toggle" type="checkbox" name="all_days" id="all_days" data-on="Si" data-off="No">
                            @else
                                <input data-toggle="toggle" type="checkbox" name="all_days" id="all_days" data-on="Si" data-off="No">
                            @endif

                        @if ($errors->has('all_days'))
                            <span class="help-block">
                                <strong>{{ $errors->first('all_days') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group col-md-12" id="div-date" @if ( ! empty($tasks['all_days']) && $tasks['all_days'] == true) style="display: none" @endif>
                        <label for="show_on">Mostrar sólo el </label>
                        <div id="sandbox-container-show" class="input-group">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                            @if ( ! empty($tasks['show_on']))
                            <input id="show_on" type="text" class="form-control datepicker" name="show_on" value="{{ $tasks['show_on'] }}" placeholder="Seleccione fecha para mostrar tarea...">
                            @else
                            <input id="show_on" type="text" class="form-control datepicker" name="show_on" value="{{ old('show_on') }}" placeholder="Seleccione fecha para mostrar tarea...">
                            @endif

                        </div>
                    </div>

                    <div class="col-md-12 form-group" id="div-employee" @if (! empty($tasks['all_employees']) && $tasks['all_employees'] == true) style="display: none" @endif>
                        <label for="responsable_user_id" >Responsable de la tarea</label>
                            <select class="form-control" name="responsable_user_id" id="responsable_user_id" >

                                    @if ( !empty($users))
                                            <option value="0">- Seleccione - </option>

                                        @foreach($users as $item)
                                            @if ( ! empty($tasks['responsable_user_id']))
                                            <option value="{{$item->id}}" @if($tasks['responsable_user_id'] == $item->id) selected @endif >{{$item->name}} {{$item->last_name}}</option>
                                            @else
                                            <option value="{{$item->id}}" >{{$item->name}} {{$item->last_name}}</option>
                                            @endif
                                        @endforeach

                                    @endif
                                    
                            </select>
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description">Descripción</label>
                            @if ( ! empty($tasks['description']))
                                <input id="description" type="text" class="form-control" name="description" value="{{ $tasks['description'] }}" placeholder="Ingrese la description de la tarea..." >
                            @else
                                <input id="description" type="text" class="form-control" name="description" value="{{ old('description') }}" placeholder="Ingrese la description de la tarea..." >
                            @endif

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group col-md-12">
                        <label for="status" class="col-md-4 control-label">Estatus</label>

                            @if ( ! empty($tasks['status']))
                            <select id="status" class="selectpicker form-control" name="status">
                                @if ( $tasks['status'] == "Activo")
                                <option value="Activo" selected="selected">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                                @else
                                <option value="Activo">Activo</option>
                                <option value="Inactivo" selected="selected">Inactivo</option>
                                @endif

                            </select>
                            @else
                            <select id="sexo" class="selectpicker form-control" name="status">
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
@endsection

