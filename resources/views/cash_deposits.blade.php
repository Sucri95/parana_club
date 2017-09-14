@extends('layouts.app')

@section('content')
@if(Auth::check() && Auth::user()->hasRole('admin'))
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Depósitos</div>

                <div class="panel-body">

                            @if ( ! empty($cash_deposits['amount']))
                            {{ Form::model($cash_deposits, array('route' => array('cash_deposits.update', $cash_deposits->id), 'method' => 'PUT')) }}

                            @else
                            {!! Form::open(['route' => 'cash_deposits.store', 'method' => 'POST', 'files' => 'true']) !!}
                            @endif

                    {{ csrf_field() }}


                    <div class="col-md-12 form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                        <label for="amount" >Monto depósito </label>
                            @if ( ! empty($cash_deposits['amount']))
                                <input id="amount" type="text" class="form-control" name="amount" value="{{ $cash_deposits['amount'] }}">
                            @else
                                <input id="amount" type="text" class="form-control" name="amount" value="{{ old('amount') }}">
                            @endif

                        @if ($errors->has('amount'))
                            <span class="help-block">
                                <strong>{{ $errors->first('amount') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('deposit_number') ? ' has-error' : '' }}">
                        <label for="deposit_number" >Número de depósito </label>
                            @if ( ! empty($cash_deposits['deposit_number']))
                                <input id="deposit_number" type="text" class="form-control" name="deposit_number" value="{{ $cash_deposits['deposit_number'] }}" readonly="true">
                            @else
                                <input id="deposit_number" type="text" class="form-control" name="deposit_number" value="{{ $number }}" readonly="true">
                            @endif

                        @if ($errors->has('deposit_number'))
                            <span class="help-block">
                                <strong>{{ $errors->first('deposit_number') }}</strong>
                            </span>
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
@else
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Página no encontrada</div>

                <div class="panel-body">
                    Verifique que ha escrito bien la dirección de enlace. 
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

