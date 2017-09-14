@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Venta productos</div>

                <div class="panel-body">

                            @if ( ! empty($sales['activity_id']))
                            {{ Form::model($sales, array('route' => array('sales.update', $sales->id), 'method' => 'PUT')) }}
                            <input type="text" id="class_id" value="{{ $sales->id }}" style="display: none">

                            @else
                            {!! Form::open(['route' => 'sales.store', 'method' => 'POST', 'files' => 'true']) !!}
                            @endif

                    {{ csrf_field() }}


                    <div class="col-md-12 form-group{{ $errors->has('document') ? ' has-error' : '' }}">
                        <label for="document">DNI</label>
                            <div class="input-group">
                                <div class="input-group-addon" onclick="getByDNI();"><span class="glyphicon glyphicon-search"></span></div>
                                @if ( ! empty($sales['document']))
                                    <input type="text" class="form-control" name="document" id="document"  value="{{ $sales['document'] }}">
                                @else
                                    <input type="text" class="form-control" name="document" id="document" >
                                @endif
                            </div>
                                    

                        @if ($errors->has('document'))
                            <span class="help-block">
                                <strong>{{ $errors->first('document') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-12 form-group">
                            
                            <label id="client_name" style="display: none"></label>

                            <input type="text" class="form-control" name="uid_user" id="uid_user" style="display: none" >
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="product_id">Producto</label>

                            @if ( ! empty($sales['product_id']))

                            <input id="product_id" type="text" class="form-control" name="product_id" value="{{ $sales['product_name'] }}">
                            <input id="product_uid" type="text" class="form-control" name="product_uid" style="display: none;" value="{{ $sales['product_id'] }}">

                            @else

                            <input id="product_id" type="text" class="form-control" name="product_id" value="{{ old('product') }}">
                            <input id="product_uid" type="text" class="form-control" name="product_uid" style="display: none;">
                            <input id="product_price" type="text" class="form-control" name="product_price" style="display: none;">

                            @endif

                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                        <label for="quantity" class="col-md-4 control-label">Cantidad</label>

                            @if ( ! empty($sales['quantity']))
                                <input type="number" class="form-control" name="quantity" id="quantity"  value="{{ $sales['quantity'] }}">
                            @else
                                <input type="number" class="form-control" name="quantity" id="quantity" >
                            @endif


                        @if ($errors->has('quantity'))
                            <span class="help-block">
                                <strong>{{ $errors->first('quantity') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-6 form-group{{ $errors->has('sub_total') ? ' has-error' : '' }}">
                        <label for="sub_total" class="col-md-4 control-label">Sub-Total</label>
                        <div class="col-md-8">
                            @if ( ! empty($sales['sub_total']))
                                <input type="text" class="form-control" name="sub_total" id="sub_total"  value="{{ $sales['sub_total'] }}" readonly="true">
                            @else
                                <input type="text" class="form-control" name="sub_total" id="sub_total" readonly="true">
                            @endif
                        </div>

                        @if ($errors->has('sub_total'))
                            <span class="help-block">
                                <strong>{{ $errors->first('sub_total') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <a class="btn btn-default btn-circle" id="addSaleDetail"><i class="fa fa-check"></i></a>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="panel-body">
                                    <div id="listDetails"></div>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Precio Unitario</th>
                                                <th>Cantidad</th>
                                                <th>Sub-total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-list">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 form-group">
                        <label for="sub_total" class="col-md-4 control-label">Total</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="total" id="total" readonly="true">
                        </div>
                    </div>

                    <div class="col-md-12 form-group">
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

