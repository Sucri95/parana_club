@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Estadísticas de rentabilidad de actividades</div>
                <div class="panel-body">

                    <div class="form-group col-md-12">
                        <label for="start_date">Fecha de inicio</label>
                        <div id="sandbox-container-inicio" class="input-group">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                            @if ( ! empty($classes['start_date']))
                            <input id="start_date" type="text" class="form-control datepicker" name="start_date" value="{{ $classes['start_date'] }}" placeholder="Seleccione fecha de inicial">
                            @else
                            <input id="start_date" type="text" class="form-control datepicker" name="start_date" value="{{ old('start_date') }}" placeholder="Seleccione fecha de inicial">
                            @endif

                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="end_date">Fecha fin</label>
                        <div id="sandbox-container-fin" class="input-group">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                            @if ( ! empty($classes['end_date']))
                            <input id="end_date" type="text" class="form-control datepicker" name="end_date" value="{{ $classes['end_date'] }}" placeholder="Seleccione fecha final">
                            @else
                            <input id="end_date" type="text" class="form-control datepicker" name="end_date" value="{{ old('end_date') }}" placeholder="Seleccione fecha final">
                            @endif

                        </div>
                    </div>

                    <div class="col-md-12 form-group text-center">
                            <button class="btn btn-primary" id="statistics_check" onclick="getProfitability();">Guardar</button>
                    </div>

                    <div id="append_profits" class="col-md-12 form-group text-center">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection