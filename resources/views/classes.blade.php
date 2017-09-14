@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Clases/Agenda</div>

                <div class="panel-body">

                            @if ( ! empty($classes['activity_id']))
                            {{ Form::model($classes, array('route' => array('classes.update', $classes->id), 'method' => 'PUT')) }}
                            <input type="text" id="class_id" value="{{ $classes->id }}" style="display: none">

                            @else
                            {!! Form::open(['route' => 'classes.store', 'method' => 'POST', 'files' => 'true']) !!}
                            @endif

                    {{ csrf_field() }}


                    <div class="col-md-12 form-group">
                        <label for="activities" >Actividad/Disciplina</label>
                            <select class="form-control" name="activities" id="activity_id" >

                                    @if ( !empty($activities))
                                            <option value="0">- Seleccione - </option>

                                        @foreach($activities as $item)
                                            @if ( ! empty($classes['activity_id']))
                                            <option value="{{$item->id}}" type="{{$item->m2}}" @if($classes['activity_id'] == $item->id) selected @endif >{{$item->name}}</option>
                                            @else
                                            <option value="{{$item->id}}" type="{{$item->m2}}">{{$item->name}}</option>
                                            @endif
                                        @endforeach

                                    @endif
                                    
                            </select>
                    </div>

                    <div class="col-md-12 form-group">
                        <label for="classes">Salones</label>

                            <select class="form-control" name="classrooms" id="classroom_id">

                                    @if ( !empty($classrooms))
                                            <option value="0">- Seleccione - </option>

                                        @foreach($classrooms as $item)
                                            @if ( ! empty($classes['classroom_id']))
                                            <option value="{{$item->id}}"  type="{{$item->m2}}" @if($classes['classroom_id'] == $item->id) selected @endif >{{$item->name}}</option>
                                            @else
                                            <option value="{{$item->id}}"  type="{{$item->m2}}">{{$item->name}}</option>
                                            @endif
                                        @endforeach

                                    @endif
                                    
                            </select>
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('capacity') ? ' has-error' : '' }}">
                        <label for="capacity">Capacidad</label>

                            @if ( ! empty($classes['capacity']))
                                <input type="text" class="form-control" name="capacity" id="capacity"  value="{{ $classes['capacity'] }}" readonly="true" placeholder="La capacidad de la clase se calcula automáticamente...">
                            @else
                                <input type="text" class="form-control" name="capacity" id="capacity" readonly="true" placeholder="La capacidad de la clase se calcula automáticamente...">
                            @endif


                        @if ($errors->has('capacity'))
                            <span class="help-block">
                                <strong>{{ $errors->first('capacity') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-12 form-group">
                        <label for="tutors" >Tutor/Profesor</label>
                            @if ( ! empty($classes['tutor_id']))

                            <input id="tutor_id" type="text" class="form-control" name="tutor_id" value="{{ $classes['tutor_name'] }}" placeholder="Ingrese el nombre del tutor...">
                            <input id="tutor_uid" type="text" class="form-control" name="tutor_uid" style="display: none;" value="{{ $classes['tutor_id'] }}">

                            @else

                            <input id="tutor_id" type="text" class="form-control" name="tutor_id" value="{{ old('tutor') }}" placeholder="Ingrese el nombre del tutor...">
                            <input id="tutor_uid" type="text" class="form-control" name="tutor_uid" style="display: none;">

                            @endif
                    </div>

                    <div class="form-group col-md-12">
                        <label for="start_date">Fecha de inicio</label>
                        <div id="sandbox-container-inicio" class="input-group">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                            @if ( ! empty($classes['start_date']))
                            <input id="start_date" type="text" class="form-control datepicker" name="start_date" value="{{ $classes['start_date'] }}" placeholder="Seleccione fecha de inicio de la clase...">
                            @else
                            <input id="start_date" type="text" class="form-control datepicker" name="start_date" value="{{ old('start_date') }}" placeholder="Seleccione fecha de inicio de la clase...">
                            @endif

                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="end_date">Fecha fin</label>
                        <div id="sandbox-container-fin" class="input-group">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                            @if ( ! empty($classes['end_date']))
                            <input id="end_date" type="text" class="form-control datepicker" name="end_date" value="{{ $classes['end_date'] }}" placeholder="Seleccione fecha fin de la clase...">
                            @else
                            <input id="end_date" type="text" class="form-control datepicker" name="end_date" value="{{ old('end_date') }}" placeholder="Seleccione fecha fin de la clase...">
                            @endif

                        </div>
                    </div>


                    <div class="form-group col-md-12">
                        <label for="status">Estatus</label>


                            @if ( ! empty($classes['status']))
                            <select id="status" class="selectpicker form-control" name="status">
                                @if ( $classes['status'] == "Activo")
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


                    <div class="container">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Horarios</div>

                                    <div class="panel-body">   

                                        <div class="col-md-3 form-group no-padding">
                                            <label for="days" class="col-md-3 control-label">Día</label>
                                            <div class="col-md-9">

                                                <select class="form-control" name="days" id="days" >

                                                        @if ( !empty($days))
                                                                <option value="0">- Seleccione - </option>

                                                            @foreach($days as $item)
                                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                                            @endforeach
                                                        @endif                                                        
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3 form-group no-padding">
                                            <label for="schedules" class="col-md-3 control-label">Hora Inicio</label>
                                            <div class="col-md-9">

                                                <select class="form-control" name="schedules_start" id="schedules_start" >

                                                        @if ( !empty($schedules))
                                                                <option value="0">- Seleccione - </option>

                                                            @foreach($schedules as $item)
                                                                <option value="{{$item->id}}">{{$item->description}}</option>
                                                            @endforeach
                                                        @endif                                                        
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3 form-group no-padding">
                                            <label for="schedules" class="col-md-3 control-label">Hora Fin</label>
                                            <div class="col-md-9">

                                                <select class="form-control" name="schedules_end" id="schedules_end" >

                                                        @if ( !empty($schedules))
                                                                <option value="0">- Seleccione - </option>

                                                            @foreach($schedules as $item)
                                                                <option value="{{$item->id}}">{{$item->description}}</option>
                                                            @endforeach
                                                        @endif                                                        
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-3 form-group no-padding">
                                            <label for="value" class="col-md-3 control-label">Valor</label>
                                            <div class="col-md-6">
                                                @if ( ! empty($classes['value']))
                                                    <input id="value" type="text" class="form-control" name="value" value="{{ $classes['value'] }}">
                                                @else
                                                    <input id="value" type="text" class="form-control" name="value" value="{{ old('value') }}">
                                                @endif
                                            </div>

                                            <div class="col-md-3">
                                                <a class="btn btn-default btn-circle" id="addSchedule"><i class="fa fa-check"></i></a>
                                            </div>

                                            @if ($errors->has('value'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('value') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">Calendario</div>

                                                        <div class="panel-body calendar">   

                                                        <table style="width:100%">
                                                          <tr>
                                                                <th>Horas</th>

                                                            @if ( !empty($days))
                                                                @foreach($days as $item)
                                                                @if ($item->name != "Todos")
                                                                    <th id="d-{{$item->id}}">{{$item->name}}</th>
                                                                @endif
                                                                @endforeach
                                                            @endif   
                                                          </tr>
                                                            @if ( !empty($schedules))

                                                                @for ($i = 0; $i < count($schedules); $i++)
                                                                <tr>


                                                                @php ($j = $i)

                                                                <input type="text" name="next" value="{{ ++$j }}" style="display: none;">

                                                                @if($j < count($schedules))

                                                                    <th id="s-{{$schedules[$i]->id}}">{{$schedules[$i]->description}} - {{$schedules[$j]->description}}</th>

                                                                    @if ( !empty($days))
                                                                    @foreach($days as $itemday)
                                                                    @if ($itemday->name != "Todos")
                                                                        <th id="d-{{$itemday->id}}-s-{{$schedules[$i]->id}}"></th>
                                                                    @endif
                                                                    @endforeach
                                                                    @endif   
                                                                @endif
                                                                </tr>
                                                                @endfor


                                                            @endif 

                                                        </table>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 form-group" id="inputs-schedules">
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

