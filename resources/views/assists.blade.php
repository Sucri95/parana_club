@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Registrar Asistencias</div>

                <div class="panel-body">

                            @if ( ! empty($assists['activity_id']))
                            {{ Form::model($assists, array('route' => array('assists.update', $assists->id), 'method' => 'PUT')) }}
                            <input type="text" id="class_id" value="{{ $assists->id }}" style="display: none">

                            @else
                            {!! Form::open(['route' => 'assists.store', 'method' => 'POST', 'files' => 'true']) !!}
                            @endif

                    {{ csrf_field() }}


                    <div class="col-md-12 form-group{{ $errors->has('document') ? ' has-error' : '' }}">
                        <label for="document">DNI</label>
                            <div class="input-group">
                                <div class="input-group-addon" onclick="getByDNI();"><span class="glyphicon glyphicon-search"></span></div>
                                @if ( ! empty($assists['document']))
                                    <input type="text" class="form-control" name="document" id="document"  value="{{ $assists['document'] }}">
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
                        <label for="document">Actividad</label>
                            <div class="input-group">
                                <select class="form-control" name="class_id" id="class_id">

                                    <?php echo $assists[0]['name']; ?>
                                @if ( !empty($assists))
                                    <option value="0">- Seleccione - </option>

                                   <?php for ($i=0; $i < count($assists); $i++) { ?>
                                       <option value="{{$assists[$i]['class_id']}}">{{$assists[$i]['name']}}</option>
                                   <?php } ?>

                                @endif

                                </select>
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

