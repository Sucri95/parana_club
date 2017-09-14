@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Tareas
                    <a href="{{url('site/store_task/user')}}" class="btn-xs btn-primary pull-right" role="button">Agregar</a>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Responsable</th>
                                <th>Mostrar</th>
                                <th>Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ( !empty($tasks))
                            @foreach($tasks as $item)
                            <tr>
                                <th> {{ $item->description }}</th>

                                @if($item->all_employees == 1)
                                <th>Todos los empleados</th>
                                @else
                                <th> {{ $item->responsable }}</th>
                                @endif
                                @if($item->all_days == 1)
                                <th> Todos los días</th>
                                @else
                                <th>
                                    {{ $item->show_on }}
                                </th>
                                @endif
                                <th> {{ $item->status }}</th>
                                <th> 
                                    @if( $item->id )
                                    <a class="btn btn-default btn-circle" href="{{ url('/tasks/' . $item->id) }}"><i class="fa fa-pencil"></i></a>
                                    {{ Form::open([ 'method'  => 'delete', 'route' => [ 'tasks.destroy', $item->id ] ]) }}
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