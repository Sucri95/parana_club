@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Listado Tutores/Profesores
                    <a href="{{url('tutors/create')}}" class="btn-xs btn-primary pull-right" role="button">Agregar</a>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre Apellido</th>
                                <th>Email</th>
                                <th>Telefono</th>
                                <th>Actividades</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ( !empty($tutors))
                            @foreach($tutors as $item)
                            <tr>
                                <th><div class="col-md-2">
                                @if(!empty($item->image))
                                <img class="circular_small hidden-xs" src="storage/profile/{{ $item->image }}" style="display: block;">
                                @else
                                <img class="circular_small hidden-xs" src="storage/profile/default_profile.png" style="display: block;">
                                @endif
                                </div>
                                <div class="col-md-6"> {{ $item->name }} {{ $item->last_name }}</div></th>
                                <th> {{ $item->email }}</th>
                                <th> {{ $item->phone_number }}</th>
                                <th>
                                @foreach($item->classes as $activity)
                                
                                 {{ $activity->activity->name }} <br>

                                @endforeach
                                </th>
                                <th> 
                                    @if( $item->id )
                                    <a class="btn btn-default btn-circle" href="{{ url('/tutors/' . $item->id) }}"><i class="fa fa-pencil"></i></a>
                                    {{ Form::open([ 'method'  => 'delete', 'route' => [ 'tutors.destroy', $item->id ] ]) }}
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