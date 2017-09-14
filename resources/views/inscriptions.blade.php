@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Inscripciones</div>

                <div class="panel-body">

                            @if ( ! empty($inscriptions['name']))
                            {{ Form::model($inscriptions, array('route' => array('inscriptions.update', $inscriptions->id), 'method' => 'PUT')) }}

                            @else
                            {!! Form::open(['route' => 'inscriptions.store', 'method' => 'POST', 'files' => 'true']) !!}
                            @endif

                    {{ csrf_field() }}


                    <div class="col-md-6 form-group">
                        <label for="user_id" class="col-md-4 control-label">Usuario</label>
                        <div class="col-md-8">
                            @if ( ! empty($inscriptions['user_id']))

                            <input id="user_id" type="text" class="form-control" name="user_id" value="{{ $inscriptions['user_name'] }}" readonly="true">
                            <input id="user_uid" type="text" class="form-control" name="user_uid" style="display: none;" value="{{ $inscriptions['user_id'] }}" readonly="true">

                            @else

                            <input id="user_id" type="text" class="form-control" name="user_id" value="{{ old('user') }}">
                            <input id="user_uid" type="text" class="form-control" name="user_uid" style="display: none;">

                            @endif


                        </div>
                    </div>


                    <div class="form-group col-md-6">
                        <label for="status" class="col-md-4 control-label">Estatus</label>
                        <div class="col-md-6">

                            @if ( ! empty($inscriptions['status']))
                            <select id="status" class="selectpicker form-control" name="status">
                                @if ( $inscriptions['status'] == "Activo")
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
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="class_day_schedule" class="col-md-4 control-label">Horarios/Actividad</label>
                        <div class="col-md-8">

                            <select class="form-control" name="class_day_schedule" id="class_day_schedule" >

                                    @if ( !empty($class_day_schedule))
                                            <option value="0">- Seleccione - </option>

                                        @foreach($class_day_schedule as $item)
                                            <option value="{{$item->id}}" type="{{$item->m2}}">{{$item->name}}</option>
                                        @endforeach

                                    @endif
                                    
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3 form-group">
                        <a class="btn btn-default btn-circle" id="addScheduleInscription"><i class="fa fa-check"></i></a>
                    </div>

                    <div class="col-md-3 form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
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


                    <div class="col-md-2 form-group" id="inputs-schedules">
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

