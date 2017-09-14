@extends('layouts.app')

@section('content')
@if(Auth::check() && Auth::user()->hasRole('admin'))
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Encuestas</div>

                <div class="panel-body">

                            @if ( ! empty($quizzes['question']))
                            {{ Form::model($quizzes, array('route' => array('quizzes.update', $quizzes->id), 'method' => 'PUT')) }}

                            @else
                            {!! Form::open(['route' => 'quizzes.store', 'method' => 'POST', 'files' => 'true']) !!}
                            @endif

                    {{ csrf_field() }}

                    <div class="col-md-12 form-group">
                        <label for="categories">Categoría</label>
                            <select class="form-control" name="categories" id="categories">

                                    @if ( !empty($categories))

                                        @foreach($categories as $item)
                                            @if ( ! empty($quizzes['categories_id']))
                                            <option value="{{$item->id}}"  @if($quizzes['categories_id'] == $item->id) selected @endif >{{$item->name}}</option>
                                            @else
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endif
                                        @endforeach

                                    @endif
                                    
                            </select>
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('question') ? ' has-error' : '' }}">
                        <label for="question" >Pregunta </label>
                            @if ( ! empty($quizzes['question']))
                                <input id="question" type="text" class="form-control" name="question" value="{{ $quizzes['question'] }}">
                            @else
                                <input id="question" type="text" class="form-control" name="question" value="{{ old('question') }}">
                            @endif

                        @if ($errors->has('question'))
                            <span class="help-block">
                                <strong>{{ $errors->first('question') }}</strong>
                            </span>
                        @endif
                    </div>


                    <div class="form-group col-md-12">
                        <label for="status">Estatus</label>


                            @if ( ! empty($quizzes['status']))
                            <select id="status" class="selectpicker form-control" name="status">
                                @if ( $quizzes['status'] == "Activo")
                                <option value="Activo" selected="selected">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                                @else
                                <option value="Activo">Activo</option>
                                <option value="Inactivo" selected="selected">Inactivo</option>
                                @endif

                            </select>
                            @else
                            <select id="status" class="selectpicker form-control" name="status">
                                <option>Seleccione</option>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                            @endif
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
                        <label for="answer" class="col-md-4 control-label">¿Esta pregunta tiene respuesta correcta?</label>

                            @if ( ! empty($quizzes['answer']) && $quizzes['answer'] == true)
                                <input checked data-toggle="toggle" type="checkbox" name="answer" id="answer" data-on="Si" data-off="No">
                            @else
                                <input data-toggle="toggle" type="checkbox" name="answer" id="answer" data-on="Si" data-off="No">
                            @endif

                        @if ($errors->has('answer'))
                            <span class="help-block">
                                <strong>{{ $errors->first('answer') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('answer_option') ? ' has-error' : '' }}" id="div-answer"  @if ( ! empty($quizzes['answer']) && $quizzes['answer'] == true) @else style="display: none;" @endif>
                        <label for="answer_option" >Respuesta Correcta </label>
                            @if ( ! empty($quizzes['answer_option']))
                                <input id="answer_option" type="text" class="form-control" name="answer_option" value="{{ $quizzes['answer_option'] }}">
                                <input id="answer_id" type="text" class="form-control" name="answer_id" value="{{ $quizzes['answer_id'] }}" style="display: none">
                            @else
                                <input id="answer_option" type="text" class="form-control" name="answer_option" value="{{ old('answer_option') }}">
                            @endif

                        @if ($errors->has('answer_option'))
                            <span class="help-block">
                                <strong>{{ $errors->first('answer_option') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-12 form-group{{ $errors->has('option') ? ' has-error' : '' }}" >
                        <a class="btn btn-default btn-circle" id="addOptionsQuizzes"><i class="fa fa-plus"></i> Agregar opción</a>

                        <div id="options-input">
                            @if ( ! empty($quizzes['options']))
                                @foreach ($quizzes['options'] as $options)
                                <div class="input-group margin-top" id="{{$options->id}}">
                                    <div class="input-group-addon" onclick="removeOptionAnswer('{{$options->id}}')"><span class="glyphicon glyphicon-remove"></span></div>
                                    <input type="text" class="form-control" name="option-{{ $options->id }}" value="{{ $options->option }}">
                                    <input type="text" class="form-control" name="ids[]" value="{{ $options->id }}" style="display: none">
                                </div>
                                @endforeach
                            @else
                                <input type="text" class="form-control margin-top" name="option[]" value="{{ old('option') }}">
                            @endif


                        </div>

                        @if ($errors->has('option'))
                            <span class="help-block">
                                <strong>{{ $errors->first('option') }}</strong>
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

