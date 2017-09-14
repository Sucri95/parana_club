@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Tutores/Profesores</div>

                <div class="panel-body">

                            @if ( ! empty($tutors['name']))
                            {{ Form::model($tutors, array('route' => array('tutors.update', $tutors->id), 'method' => 'PUT')) }}
                            <input type="text" id="tutor_id" value="{{ $tutors->id }}" style="display: none">

                            @else
                            {!! Form::open(['route' => 'tutors.store', 'method' => 'POST', 'files' => 'true']) !!}
                            @endif

                    {{ csrf_field() }}


                    <div class="col-md-12 form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Nombre</label>

                            @if ( ! empty($tutors['name']))
                                <input id="name" type="text" class="form-control" name="name" value="{{ $tutors['name'] }}"  placeholder="Ingrese el nombre del tutor...">
                            @else
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"  placeholder="Ingrese el nombre del tutor...">
                            @endif


                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label for="last_name" >Apellido</label>

                            @if ( ! empty($tutors['last_name']))
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ $tutors['last_name'] }}" placeholder="Ingrese el apellido del tutor...">
                            @else
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Ingrese el apellido del tutor...">
                            @endif


                        @if ($errors->has('last_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" >Email</label>
                        <div class="input-group">
                            <div class="input-group-addon">@</div>
                            @if ( ! empty($tutors['email']))
                                <input id="email" type="text" class="form-control" name="email" value="{{ $tutors['email'] }}" placeholder="Ingrese el email del tutor...">
                            @else
                                <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Ingrese el email del tutor...">
                            @endif
                        </div>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>


                    <div class="col-md-12 form-group{{ $errors->has('document') ? ' has-error' : '' }}">
                        <label for="document">Documento</label>
                        @if ( ! empty($tutors['document']))
                            <input id="document" type="text" class="form-control" name="document" value="{{ $tutors['document'] }}" placeholder="Ingrese el documento del tutor...">
                        @else
                            <input id="document" type="text" class="form-control" name="document" placeholder="Ingrese el documento del tutor..." value="{{ old('document') }}" required autofocus>
                        @endif

                        @if ($errors->has('document'))
                        <span class="help-block">
                            <strong>{{ $errors->first('document') }}</strong>
                        </span>
                        @endif

                    </div>


                    <div class="col-md-12 form-group">
                        <label for="genre">Género</label>
                        @if ( ! empty($tutors['genre']))

                            <select class="form-control" id="genre" name="genre"><option @if ( $tutors['genre'] == "Masculino") selected="true" @endif value="Masculino">Hombre</option><option @if ( $tutors['genre'] == "Femenino") selected="true" @endif  value="Femenino">Mujer</option></select>

                        @else
                            <select class="form-control" id="genre" name="genre"><option value="Masculino">Hombre</option><option value="Femenino">Mujer</option></select>
                        @endif
                    </div>


                    <div class="col-md-12 form-group">
                        <label for="birthdate">Fecha de Nacimiento</label>
                        <div class="input-group">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                            @if ( ! empty($tutors['genre']))
                                <input class="form-control datepicker" name="birthdate" id="birthdate" type="text" value="{{ $tutors['birthdate'] }}" placeholder="Ingrese la fecha de nacimiento del tutor...">

                            @else
                                <input class="form-control datepicker" name="birthdate" id="birthdate" type="text" placeholder="Ingrese la fecha de nacimiento del tutor...">
                            @endif
                        </div>
                        <!--p class="small">Puede indicar solo el día y el mes de la fecha para conocer el Cumpleaños.</p-->
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                        <label for="phone_number" >Teléfono</label>
                        <div class="input-group">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></div>
                            @if ( ! empty($tutors['phone_number']))
                                <input id="phone_number" type="text" class="form-control" name="phone_number" value="{{ $tutors['phone_number'] }}">
                            @else
                                <input id="phone_number" type="text" class="form-control" name="phone_number" value="{{ old('phone_number') }}">
                            @endif
                        </div>

                        @if ($errors->has('phone_number'))
                            <span class="help-block">
                                <strong>{{ $errors->first('phone_number') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                        <label for="address">Dirección</label>
                        <div class="input-group">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-home"></span></div>
                            @if ( ! empty($tutors['address']))
                                <input class="form-control" placeholder="Ingrese la dirección del usuario..." name="address" id="address" type="text" value="{{ $tutors['address'] }}" required autofocus>
                            @else
                                <input class="form-control" placeholder="Ingrese la dirección del usuario..." name="address" id="address" type="text" value="{{ old('address') }}" required autofocus>
                            @endif

                            @if ($errors->has('address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <!--div class="form-group col-md-12">
                        <label for="status">Estatus</label>


                            @if ( ! empty($tutors['status']))
                            <select id="status" class="selectpicker form-control" name="status">
                                @if ( $tutors['status'] == "Activo")
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

                    </div-->

                    <div class="col-md-12 form-group{{ $errors->has('file') ? ' has-error' : '' }} no-margin-bottom">
                        <label for="file">Imagen</label>                      

                        @if ( ! empty($tutors['image']))
                        <div class="col-md-6">
                            <div class="thumbnail">
                                <img src="../storage/profile/thumb_{{$tutors['image']}}">
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



                    <!--div class="col-md-6 form-group" id="div-list-activities" style="display: none;">
                        <span id="listActivities" class="col-md-12 help-block">
                        </span>

                        <div id="input-div" class="col-md-8 margin-left">
                        </div>

                        <input type="text" name="total_activities" id="total_activities" style="display:none" value="0">

                    </div-->


                    <div class="col-md-12 form-group">
                        <label for="activities">Actividad/Disciplina</label>

                            <select class="form-control" name="activities" id="activities">

                                    @if ( !empty($activities))
                                        <option value="0">Seleccione</option>


                                        @foreach($activities as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach

                                    @endif
                                    
                            </select>
                    </div>

        <div class="col-md-6 form-group" id="activitySelected">
          <label class="col-sm-12 text-left text-nowrap">Actividades seleccionadas</label>
          <div class="col-sm-12">
          <ul class="list-group" id="listActivities">
          </ul>

          </div>
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

