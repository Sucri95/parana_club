@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Usuarios inactivos
                    <a href="{{url('new_user')}}" class="btn-xs btn-primary pull-right" role="button">Agregar</a>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre y Apellido</th>
                                <th>Email</th>
                                <th>Telefono</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ( !empty($users))
                            @foreach($users as $item)
                            <tr>
                                <th>
                                <div class="col-md-2">
                                @if(!empty($item->image))
                                <img class="circular_small hidden-xs" src="storage/profile/{{ $item->image }}" style="display: block;">
                                @else
                                <img class="circular_small hidden-xs" src="storage/profile/default_profile.png" style="display: block;">
                                @endif
                                </div>
                                <div class="col-md-6"> {{ $item->name }} {{ $item->last_name }}</div></th>
                                <th> {{ $item->email }}</th>
                                <th> {{ $item->phone_number }}</th>

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