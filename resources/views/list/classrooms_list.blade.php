@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Listado Salones
                    <a href="{{url('classrooms/create')}}" class="btn-xs btn-primary pull-right" role="button">Agregar</a>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Observación</th>
                                <th>Metros Cuadrados</th>
                                <th>Imagen</th>
                                <th>Tipo</th>
                                <th>Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ( !empty($classrooms))
                            @foreach($classrooms as $item)
                            <tr>
                                <th> {{ $item->name }}</th>
                                <th> {{ $item->observation }}</th>
                                <th> {{ $item->m2 }}</th>
                                <th> {{ $item->image }}</th>
                                <th> {{ $item->type }}</th>
                                <th> {{ $item->status }}</th>
                                <th> 
                                    @if( $item->id )
                                    <a class="btn btn-default btn-circle" href="{{ url('/classrooms/' . $item->id) }}"><i class="fa fa-pencil"></i></a>
                                    {{ Form::open([ 'method'  => 'delete', 'route' => [ 'classrooms.destroy', $item->id ] ]) }}
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