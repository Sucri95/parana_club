@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Listado Productos
                    <a href="{{url('products/create')}}" class="btn-xs btn-primary pull-right" role="button">Agregar</a>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Precio de Venta</th>
                                <th>Stock Inicial</th>
                                <th>Stock Actual</th>
                                <th>Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ( !empty($products))
                            @foreach($products as $item)
                            <tr>
                                <th> {{ $item->name }}</th>
                                <th> {{ $item->cost }}</th>
                                <th> {{ $item->stock_inicial }}</th>
                                <th> {{ $item->stock_actual }}</th>
                                <th> {{ $item->status }}</th>
                                <th> 
                                    @if( $item->id )
                                    <a class="btn btn-default btn-circle" href="{{ url('/products/' . $item->id) }}"><i class="fa fa-pencil"></i></a>
                                    {{ Form::open([ 'method'  => 'delete', 'route' => [ 'products.destroy', $item->id ] ]) }}
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