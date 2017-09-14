@extends('layouts.app')

@section('content')
@if(Auth::check() && Auth::user()->hasRole('admin'))
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Benchmarks</div>

                <div class="panel-body">

                            @if ( ! empty($benchmarks['item']))
                            {{ Form::model($benchmarks, array('route' => array('benchmarks.update', $benchmarks->id), 'method' => 'PUT')) }}

                            @else
                            {!! Form::open(['route' => 'benchmarks.store', 'method' => 'POST', 'files' => 'true']) !!}
                            @endif

                    {{ csrf_field() }}

                    <div class="col-md-12 form-group{{ $errors->has('item') ? ' has-error' : '' }}">
                        <label for="item" >Ítem </label>
                            @if ( ! empty($benchmarks['item']))
                                <input id="item" type="text" class="form-control" name="item" value="{{ $benchmarks['item'] }}">
                            @else
                                <input id="item" type="text" class="form-control" name="item" value="{{ old('item') }}">
                            @endif

                        @if ($errors->has('item'))
                            <span class="help-block">
                                <strong>{{ $errors->first('item') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group col-md-12">
                        <label for="status">Estatus</label>

                            @if ( ! empty($benchmarks['status']))
                            <select id="status" class="selectpicker form-control" name="status">
                                @if ( $benchmarks['status'] == "Activo")
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

