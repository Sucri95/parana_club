@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Listado de Ventas
                    <a href="{{url('sales/create')}}" class="btn-xs btn-primary pull-right" role="button">Agregar</a>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Productos</th>
                                <th>Usuario</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ( !empty($sales))
                            @foreach($sales as $item)
                            <tr>
                                <th>
                                @if ( !empty($item->sales_details))
                                @foreach($item->sales_details as $key)
                                     {{ $key->products->name }} <br>
                                @endforeach
                                @endif
                                </th>
                                <th> {{ $item->usuario->name }}</th>
                                <th> {{ $item->total }}</th>

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