@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Listado dee Pagos
                    <a href="{{url('paid_tutors/create')}}" class="btn-xs btn-primary pull-right" role="button">Agregar</a>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Responsable</th>
                                <th>Tutor</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                                <th>Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ( !empty($paid_tutors))
                            @foreach($paid_tutors as $item)
                            <tr>
                                <th> {{ $item->responsable_user_id }}</th>
                                <th> {{ $item->tutor_user_id }}</th>
                                <th> {{ $item->amount }}</th>
                                <th> {{ $item->created_at }}</th>
                                <th> {{ $item->status }}</th>
                                <th> 
                                    @if( $item->id )
                                    <a class="btn btn-default btn-circle" href="{{ url('/paid_tutors/' . $item->id) }}"><i class="fa fa-pencil"></i></a>
                                    {{ Form::open([ 'method'  => 'delete', 'route' => [ 'paid_tutors.destroy', $item->id ] ]) }}
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