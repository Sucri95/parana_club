@extends('layouts.app')

@section('content')
@if(Auth::check() && Auth::user()->hasRole('admin'))
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Tipos de Transacciones</div>

                <div class="panel-body">

                            @if ( ! empty($type_cash_transactions['name']))
                            {{ Form::model($type_cash_transactions, array('route' => array('type_cash_transactions.update', $type_cash_transactions->id), 'method' => 'PUT')) }}

                            @else
                            {!! Form::open(['route' => 'type_cash_transactions.store', 'method' => 'POST', 'files' => 'true']) !!}
                            @endif

                    {{ csrf_field() }}

                    <div class="col-md-12 form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" >Nombre </label>
                            @if ( ! empty($type_cash_transactions['name']))
                                <input id="name" type="text" class="form-control" name="name" value="{{ $type_cash_transactions['name'] }}">
                            @else
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
                            @endif

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" >Descripción </label>
                            @if ( ! empty($type_cash_transactions['description']))
                                <input id="description" type="text" class="form-control" name="description" value="{{ $type_cash_transactions['description'] }}">
                            @else
                                <input id="description" type="text" class="form-control" name="description" value="{{ old('description') }}">
                            @endif

                        @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group col-md-12">
                        <label for="status">Estatus</label>


                            @if ( ! empty($type_cash_transactions['status']))
                            <select id="status" class="selectpicker form-control" name="status">
                                @if ( $type_cash_transactions['status'] == "Activo")
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

