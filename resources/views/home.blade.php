@extends('layouts.app')

@section('content')
@if (Auth::user()->hasRole('admin'))

<div class="section-header">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <h1>    Resumen de Actividad      </h1>
                <p>    Una visión resumida de su negocio. </p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 top_actions">
        <div class="btn-group btn-group-sm btn-group-justified" role="group" aria-label="..."></div>
    </div>
    <div class="clear"></div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"> Indicadores</div>

                <div class="panel-body">
                    <div class="metricContainer">
                        <h3><span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Cantidad de Usuarios en la base de datos"></span> Control Balance de Caja</h3>

                        <h4 class="text-center"><span class="counter {{$balance['class']}} ">{{$balance['total']}}$</span></h4>
                        <span class="counter">Efectivo: <span class="success">{{$balance['cash']}}$</span></span>
                        <span class="counter">Depósitos: <span class="success">{{$balance['deposits']}}$</span></span>
                        <span class="counter">Egresos: <span class="failed">-{{$balance['diff']}}$</span></span>
                    </div>
                    <div class="metricContainer">
                        <h3><span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Cantidad de Usuarios inscritos en actividades"></span> Clientes </h3>
                        <h4 class="text-center"><span class="counter">{{$balance['clients']}}</span></h4>
                    </div>
                    <div class="metricContainer">
                        <h3><span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Cantidad de Usuarios que no están inscritos en ninguna clase"></span> Empleados</h3>
                        <h4 class="text-center"><span class="counter">{{$balance['employees']}}</span></h4>
                    </div>
                    <div class="metricContainer">
                        <h3><span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Cantidad de Usuarios que no están inscritos en ninguna clase"></span> Profesores</h3>
                        <h4 class="text-center"><span class="counter">{{$balance['tutor']}}</span></h4>
                    </div>
                    <div class="metricContainer">
                        <h3><span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Cantidad de Usuarios que no están inscritos en ninguna clase"></span> Productos</h3>
                        @foreach($balance['products'] as $prod)
                            <span class="counter">{{$prod->name}}</span>

                            <div class="container">
                                <span class="counter">Stock inicial: {{$prod->stock_inicial}}</span>
                                <span class="counter">Stock actual: {{$prod->stock_actual}}</span>
                            </div>

                        @endforeach
                    </div>
                    <div class="metricContainer">
                        <h3><span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Cantidad de Usuarios que no están inscritos en ninguna clase"></span> Deudores</h3>
                        @foreach($balance['debts'] as $debt)
                            <span class="counter">{{$debt['usuario']}} / DNI: {{$debt['documento']}}</span>

                            <div class="container">
                                <span class="counter">Total: <span class="failed">-{{$debt['total']}}$</span></span>
                            </div>
                            
                        @endforeach
                    </div>
                    <div class="metricContainer">
                        <h3><span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Cantidad de Usuarios que no están inscritos en ninguna clase"></span> Pago a Profesores</h3>
                        @foreach($balance['payments'] as $pay)
                            <span class="counter">{{$pay['tutor']}} / Clase: {{$pay['class']}}</span>

                            <div class="container">
                                <span class="counter">Total: {{$pay['amount']}}$</span>
                            </div>
                            
                        @endforeach
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
