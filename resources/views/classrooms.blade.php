@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Salones</div>

                <div class="panel-body">

                            @if ( ! empty($classrooms['name']))
                            {{ Form::model($classrooms, array('route' => array('classrooms.update', $classrooms->id), 'method' => 'PUT')) }}

                            @else
                            {!! Form::open(['route' => 'classrooms.store', 'method' => 'POST', 'files' => 'true']) !!}
                            @endif

                    {{ csrf_field() }}

                    <div class="col-md-12 form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Nombre</label>
                            @if ( ! empty($classrooms['name']))
                                <input id="name" type="text" class="form-control" name="name" value="{{ $classrooms['name'] }}" placeholder="Ingrese el nombre del salón...">
                            @else
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Ingrese el nombre del salón...">
                            @endif

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('observation') ? ' has-error' : '' }}">
                        <label for="observation">Observación</label>
                            @if ( ! empty($classrooms['observation']))
                                <input id="observation" type="text" class="form-control" name="observation" value="{{ $classrooms['observation'] }}" placeholder="Ingrese alguna observación del salón...">
                            @else
                                <input id="observation" type="text" class="form-control" name="observation" value="{{ old('observation') }}" placeholder="Ingrese alguna observación del salón...">
                            @endif


                        @if ($errors->has('observation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('observation') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('m2') ? ' has-error' : '' }}">
                        <label for="m2" >Metros Cuadrados</label>

                            @if ( ! empty($classrooms['m2']))
                                <input id="m2" type="text" class="form-control" name="m2" value="{{ $classrooms['m2'] }}" placeholder="Ingrese mentros cuadrados del salón...">
                            @else
                                <input id="m2" type="text" class="form-control" name="m2" value="{{ old('m2') }}" placeholder="Ingrese metros cuadrados del salón...">
                            @endif


                        @if ($errors->has('m2'))
                            <span class="help-block">
                                <strong>{{ $errors->first('m2') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('file') ? ' has-error' : '' }} no-margin-bottom">
                        <label for="file">Imagen</label>                      

                        @if ( ! empty($classrooms['image']))
                        <div class="col-md-6">
                            <div class="thumbnail">
                                <img src="../storage/thumb_{{$classrooms['image']}}">
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
                        <label for="status" class="col-md-4 control-label">Tipo</label>
                        <select id="status" class="selectpicker form-control" name="type">
                            <option value="Salón">Salón</option>
                            <option value="Cancha">Cancha</option>
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="status" class="col-md-4 control-label">Estatus</label>


                            @if ( ! empty($classrooms['status']))
                            <select id="status" class="selectpicker form-control" name="status">
                                @if ( $classrooms['status'] == "Activo")
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

