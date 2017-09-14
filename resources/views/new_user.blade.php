@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    {!! Form::open(['route' => 'users.store', 'method' => 'POST', 'files' => 'true']) !!}

                    {{ csrf_field() }}

                    <div class="col-md-12 form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" >Nombre</label>
                        <input id="name" type="text" class="form-control" name="name" placeholder="Ingrese el nombre del usuario..." value="{{ old('name') }}" required autofocus>

                        @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif

                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label for="last_name" >Apellido</label>
                        <input id="last_name" type="text" class="form-control" name="last_name" placeholder="Ingrese el apellido del usuario..." value="{{ old('last_name') }}" required autofocus>

                        @if ($errors->has('last_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">E-Mail</label>

                        <div class="input-group">
                            <div class="input-group-addon">@</div>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Ingrese el E-mail del usuario..." required>

                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>


                    <div class="col-md-12 form-group{{ $errors->has('document') ? ' has-error' : '' }}">
                        <label for="document">Documento</label>
                        <input id="document" type="text" class="form-control" name="document" placeholder="Ingrese el documento del usuario..." value="{{ old('document') }}" required autofocus>

                        @if ($errors->has('document'))
                        <span class="help-block">
                            <strong>{{ $errors->first('document') }}</strong>
                        </span>
                        @endif

                    </div>

                    <div class="col-md-12 form-group">
                        <label for="genre">Género</label>
                        <select class="form-control" id="genre" name="genre"><option value="Masculino">Hombre</option><option value="Femenino">Mujer</option></select>
                    </div>

                    <div class="col-md-12 form-group">
                        <label for="birthdate">Fecha de Nacimiento</label>
                        <div class="input-group">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                            <input class="form-control datepicker" name="birthdate" id="birthdate" type="text">
                        </div>
                        <!--p class="small">Puede indicar solo el día y el mes de la fecha para conocer el Cumpleaños.</p-->
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                        <label for="phone_number">Teléfono</label>
                        <div class="input-group">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></div>
                            <input id="phone_number" type="text" class="form-control" name="phone_number" placeholder="Ingrese un teléfono de contacto..." value="{{ old('phone_number') }}" required autofocus>

                                @if ($errors->has('phone_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                </span>
                                @endif
                        </div>
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                        <label for="address">Dirección</label>
                        <div class="input-group">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-home"></span></div>
                            <input class="form-control" placeholder="Ingrese la dirección del usuario..." name="address" id="address" type="text" value="{{ old('address') }}" required autofocus>

                            @if ($errors->has('address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>






                    <div class="col-md-12 form-group{{ $errors->has('file') ? ' has-error' : '' }} no-margin-bottom">
                        <label for="file">Imagen</label>                      

                        
                        <div class="margin-left">
                            <input type="file" name="file" class="filestyle">
                        </div>

                            @if ($errors->has('file'))
                            <span class="col-md-12 help-block">
                                <strong>{{ $errors->first('file') }}</strong>
                            </span>
                            @endif
                    </div>
                    
                    @if(!empty($roles))

                    <div class="col-md-12 form-group">
                        <label for="role" class="col-md-4 control-label">Roles</label>
                        <div class="col-md-6">
                            <select class="form-control" name="role" id="role">
                              @if ( !empty($roles))
                              @foreach($roles as $item)
                              <option value="{{$item->id}}">{{$item->display_name}}</option>
                              @endforeach
                              @endif
                            </select>
                        </div>
                    </div>

                    @endif

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Guardar
                            </button>
                        </div>
                    </div>
                {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
