@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Actividades</div>

                <div class="panel-body">

                            @if ( ! empty($activities['name']))
                            {{ Form::model($activities, array('route' => array('activities.update', $activities->id), 'method' => 'PUT')) }}

                            @else
                            {!! Form::open(['route' => 'activities.store', 'method' => 'POST', 'files' => 'true']) !!}
                            @endif

                    {{ csrf_field() }}

                    <div class="col-md-12 form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Nombre</label>

                            @if ( ! empty($activities['name']))
                                <input id="name" type="text" class="form-control" name="name" value="{{ $activities['name'] }}" placeholder="Ingrese el nombre de la actividad...">
                            @else
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Ingrese el nombre de la actividad...">
                            @endif


                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" >Descripción</label>

                            @if ( ! empty($activities['description']))
                                <input id="description" type="text" class="form-control" name="description" value="{{ $activities['description'] }}" placeholder="Ingrese la descripción de la actividad...">
                            @else
                                <input id="description" type="text" class="form-control" name="description" value="{{ old('description') }}" placeholder="Ingrese la descripción de la actividad...">
                            @endif


                        @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('m2') ? ' has-error' : '' }}">
                        <label for="m2">Metros Cuadrados</label>
                            @if ( ! empty($activities['m2']))
                                <input id="m2" type="text" class="form-control" name="m2" value="{{ $activities['m2'] }}" placeholder="Ingrese los metros cuadrados por persona...">
                            @else
                                <input id="m2" type="text" class="form-control" name="m2" value="{{ old('m2') }}" placeholder="Ingrese los metros cuadrados por persona...">
                            @endif

                        @if ($errors->has('m2'))
                            <span class="help-block">
                                <strong>{{ $errors->first('m2') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('file') ? ' has-error' : '' }} no-margin-bottom">
                        <label for="file">Imagen</label>                      

                        @if ( ! empty($activities['image']))
                        <div class="col-md-6">
                            <div class="thumbnail">
                                <img src="../storage/thumb_{{$activities['image']}}">
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
                            @if ( ! empty($activities['status']))
                            <select id="status" class="selectpicker form-control" name="status">
                                @if ( $activities['status'] == "Activo")
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

