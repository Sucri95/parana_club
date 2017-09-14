@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Productos</div>

                <div class="panel-body">

                            @if ( ! empty($products['name']))
                            {{ Form::model($products, array('route' => array('products.update', $products->id), 'method' => 'PUT')) }}

                            @else
                            {!! Form::open(['route' => 'products.store', 'method' => 'POST', 'files' => 'true']) !!}
                            @endif

                    {{ csrf_field() }}

                    <div class="col-md-12 form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Nombre</label>
                            @if ( ! empty($products['name']))
                                <input id="name" type="text" class="form-control" name="name" value="{{ $products['name'] }}" placeholder="Ingrese el nombre del producto..." >
                            @else
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Ingrese el nombre del producto..." >
                            @endif

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('cost') ? ' has-error' : '' }}">
                        <label for="cost">Precio de Venta</label>
                            @if ( ! empty($products['cost']))
                                <input id="cost" type="text" class="form-control" name="cost" value="{{ $products['cost'] }}" placeholder="Ingrese el precio de venta del producto..." >
                            @else
                                <input id="cost" type="text" class="form-control" name="cost" value="{{ old('cost') }}" placeholder="Ingrese el precio de venta del producto...">
                            @endif

                        @if ($errors->has('cost'))
                            <span class="help-block">
                                <strong>{{ $errors->first('cost') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('stock_inicial') ? ' has-error' : '' }}">
                        <label for="stock_inicial" class="col-md-4 control-label">Stock Inicial</label>

                            @if ( ! empty($products['stock_inicial']))
                                <input id="stock_inicial" type="text" class="form-control" name="stock_inicial" value="{{ $products['stock_inicial'] }}" placeholder="Ingrese el stock inicial del producto...">
                            @else
                                <input id="stock_inicial" type="text" class="form-control" name="stock_inicial" value="{{ old('stock_inicial') }}" placeholder="Ingrese el stock inicial del producto...">
                            @endif

                        @if ($errors->has('stock_inicial'))
                            <span class="help-block">
                                <strong>{{ $errors->first('stock_inicial') }}</strong>
                            </span>
                        @endif
                    </div>


                    <div class="form-group col-md-12">
                        <label for="status" class="col-md-4 control-label">Estatus</label>

                            @if ( ! empty($products['status']))
                            <select id="status" class="selectpicker form-control" name="status">
                                @if ( $products['status'] == "Activo")
                                <option value="Activo" selected="selected">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                                @else
                                <option value="Activo">Activo</option>
                                <option value="Inactivo" selected="selected">Inactivo</option>
                                @endif

                            </select>
                            @else
                            <select id="sexo" class="selectpicker form-control" name="status">
                                <option>Seleccione</option>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                            @endif
                    </div>


                    <div class="col-md-2 form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

