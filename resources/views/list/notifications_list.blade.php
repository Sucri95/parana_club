@extends('layouts.app')

@section('content')
@if(Auth::check() && Auth::user()->hasRole('admin'))

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Listado Notificaciones
                    <a href="{{url('notifications/create')}}" class="btn-xs btn-primary pull-right" role="button">Agregar</a>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Titulo</th>
                                <th>Mensaje</th>
                                <th>Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ( !empty($notifications))
                            @foreach($notifications as $item)
                            <tr>
                                <th> {{ $item->title }}</th>
                                <th> {{ $item->message }}</th>
                                <th> {{ $item->image }}</th>
                                <th> {{ $item->url }}</th>
                                <th> {{ $item->status }}</th>
                                <th> 

                                    @if( $item->id )
                                    <a class="btn btn-default btn-circle" href="{{ url('/notifications_user/'. $item->id) }}"><i class="fa fa-users"></i></a>
                                    <a class="btn btn-default btn-circle" href="{{ url('/notifications/' . $item->id) }}"><i class="fa fa-pencil"></i></a>
                                    {{ Form::open([ 'method'  => 'delete', 'route' => [ 'notifications.destroy', $item->id ] ]) }}
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