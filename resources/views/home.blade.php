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
                        <h3><span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Cantidad de Usuarios en la base de datos"></span> Clientes Totales</h3>
                        <h4><span class="counter">0</span></h4>
                    </div>
                    <div class="metricContainer">
                        <h3><span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Cantidad de Usuarios inscritos en actividades"></span> Clientes Activos</h3>
                        <h4><span class="counter">0</span></h4>
                    </div>
                    <div class="metricContainer">
                        <h3><span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Cantidad de Usuarios que no están inscritos en ninguna clase"></span> Clientes Inactivos</h3>
                        <h4><span class="counter">0</span></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
