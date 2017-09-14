@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Listado Inscripciones
                    <a href="{{url('inscriptions/create')}}" class="btn-xs btn-primary pull-right" role="button">Agregar</a>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Actividad</th>
                                <th>Salon</th>
                                <th>Tutor/Profesor</th>
                                <th>Usuario</th>
                                <th>Precio Clase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ( !empty($inscriptions))
                            @foreach($inscriptions as $item)
                            <tr>
                                <th> {{ $item->activity_name }}</th>
                                <th> {{ $item->classroom_name }}</th>
                                <th> {{ $item->tutor_name }}</th>
                                <th> {{ $item->usuario }}</th>
                                <th> {{ $item->value }}</th>
                                <th> 
                                    @if( $item->id )
                                    <a class="btn btn-default btn-circle" href="{{ url('/inscriptions/' . $item->id) }}"><i class="fa fa-pencil"></i></a>
                                    {{ Form::open([ 'method'  => 'delete', 'route' => [ 'inscriptions.destroy', $item->id ] ]) }}
                                    {{ csrf_field() }}
                                     <button type="submit" class="btn btn-default btn-circle"><i class="fa fa-times"></i></button>
                                     {{ Form::close() }}
                                    @endif
                                </th>

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