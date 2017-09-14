@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Listado de Encuestas
                    <a href="{{url('quizzes/create')}}" class="btn-xs btn-primary pull-right" role="button">Agregar</a>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Pregunta</th>
                                <th>Categoría</th>
                                <th>Respuesta</th>
                                <th>Estatus</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ( !empty($quizzes))
                            @foreach($quizzes as $item)
                            <tr>
                                <th> {{ $item->question}} </th>
                                <th> {{ $item->categories_name }}</th>
                                @if($item->answer == 1)
                                <th> {{ $item->answer_option }}</th>
                                @else
                                <th> No tiene respuesta correcta </th>
                                @endif
                                <th> {{ $item->status }}</th>
                                <th> 
                                    @if( $item->id )
                                    <a class="btn btn-default btn-circle" href="{{ url('/quizzes/' . $item->id) }}"><i class="fa fa-pencil"></i></a>
                                    {{ Form::open([ 'method'  => 'delete', 'route' => [ 'quizzes.destroy', $item->id ] ]) }}
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