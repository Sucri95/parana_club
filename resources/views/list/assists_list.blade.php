@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Listado de Asistencias
                    <a href="{{url('assists/create')}}" class="btn-xs btn-primary pull-right" role="button">Agregar</a>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Actividad</th>
                                <th>Salón/Cancha</th>
                                <th>Profesor</th>
                                <th>Hora</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ( !empty($assists))
                            @foreach($assists as $item)
                            <tr>
                                <th> {{ $item->client_name }}</th>
                                <th> {{ $item->activity_name }}</th>
                                <th> {{ $item->classroom_name }}</th>
                                <th> {{ $item->tutor_name }}</th>
                                <th> {{ $item->hour }}</th>
                                <th> {{ $item->date }}</th>

                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection