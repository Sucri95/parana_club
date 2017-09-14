@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Listado Clases/Agenda
                    <a href="{{url('classes/create')}}" class="btn-xs btn-primary pull-right" role="button">Agregar</a>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Actividad</th>
                                <th>Salón/Cancha</th>
                                <th>Tutor/Profesor</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ( !empty($classes))
                            @foreach($classes as $item)
                            <tr>
                                <th> {{ $item->activity_name }}</th>
                                <th> {{ $item->classroom_name }}</th>
                                <th> {{ $item->tutor_name }}</th>
                                <th> {{ $item->start_date }}</th>
                                <th> {{ $item->end_date }}</th>
                                <th> {{ $item->status }}</th>
                                <th> 
                                    @if( $item->id )
                                    <a class="btn btn-default btn-circle" href="{{ url('/classes/' . $item->id) }}"><i class="fa fa-pencil"></i></a>
                                    {{ Form::open([ 'method'  => 'delete', 'route' => [ 'classes.destroy', $item->id ] ]) }}
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