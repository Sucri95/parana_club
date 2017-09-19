@extends('layouts.app')

@section('content')
@if(Auth::check() && Auth::user()->hasRole('admin'))

<div class="container">
    <div class="row">
        <div class="col-md-11 col-md-offset-1">

                   <div class="panel panel-default">
                        <div class="panel-heading">Seleccionar Usuarios ({{ $total }})</div>

                        <div class="panel-body">

                            <form class="form-horizontal" style="display: none;" role="form" method="POST" action="{{ url('/consultarUsuarios/' . $id) }}">

                                {{ csrf_field() }}


                                <div class="col-md-8 form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                                    <label for="nombre" class="col-md-4 control-label">Ingresa Nombre o Apellido o Email</label>
                                    <div class="col-md-8">
                                        <input id="nombre" type="text" class="form-control" name="nombre" value="{{ old('nombre') }}">
                                    </div>

                                    @if ($errors->has('nombre'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-md-2 form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">Buscar</button>
                                    </div>
                                </div>
                                <div class="col-md-2 form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <a href="{{ url('/notificacionesusuarios/'. $id) }}" class="btn btn-default">Todos</a>
                                    </div>
                                </div>

                            </form>

                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/saveNotificationsUsers/' .$id) }}">
                            

                            {{ csrf_field() }}

                            <div class="container">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="tab-content">
                                                <div class="panel-body">
                                                    <table class="table table-striped">
                                                        @if(!empty($not_found) && empty($cliente))
                                                        <h2>No se encontraron usuarios con ese Nombre o Apellido</h2>
                                                        @else
                                                        <thead>
                                                            <tr>
                                                                <th>Seleccionar</th>
                                                                <th>ID</th>
                                                                <th>Nombre</th>
                                                                <th>Apellido</th>
                                                                <th>Email</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (!empty($usuarios) && empty($not_found))
                                                            @foreach($usuarios as $item)
                                                            <tr>
                                                                <th><input type="checkbox" name="seleccionados[]" class="seleccionados" value="{{ $item ->id }}" @if(!empty($seleccionados) &&  in_array($item->id, $seleccionados)) checked="checked" @endif></th>
                                                                <th> {{ $item->id }}</th>
                                                                <th> {{ $item->name }}</th>
                                                                <th> {{ $item->last_name }}</th>
                                                                <th> {{ $item->email }}</th>
                                                            </tr>
                                                            @endforeach
                                                            @endif
                                                        </tbody>
                                                        @endif

                                                    </table>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <p><input type="button" class="check" value="Check All" />
                                    <input type="button" class="uncheck" value="UnCheck All" /></p> 
                            </div>


                            <div class="col-md-2 form-group">
                                <div class="col-md-6 col-md-offset-4">

                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                            </form>
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