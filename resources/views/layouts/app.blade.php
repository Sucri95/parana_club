<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Parana Club') }}</title>
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="{{ asset('js/jquery-1.12.4.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Parana Club') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    @if (Auth::guest())
                    @else
                    @if (Auth::user()->hasRole('admin'))
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-user-circle"></i>  Clientes <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">

                                <li><a href="{{ url('/all_users') }}"><i class="fa fa-check"></i>  Todos los clientes</a></li>
                                <li><a href="{{ url('/inactive_users') }}"><i class="fa fa-clock-o"></i>  Clientes inactivos</a></li>
                                <li class="nav-divider"></li>
                                <li><a href="{{ url('/new_user') }}"><i class="fa fa-user-plus "></i>  Nuevo cliente</a></li>

                            </ul>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-check"></i>  Asistencias <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/assists/create') }}"><i class="fa fa-check "></i>  Registrar Asistencia </a></li>
                                <li><a href="{{ url('/assists') }}"><i class="fa fa-shopping-cart"></i>  Todas las asistencias </a></li>
                            </ul>
                        </li>
                    </ul>


                    <ul class="nav navbar-nav">

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-tasks"></i>  Actividades <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">

                                <li><a href="{{ url('/activities') }}"><i class="fa fa-check"></i>  Todas las actividades</a></li>
                                <li><a href="{{url('activities/create')}}"><i class="fa fa-plus"></i>  Nueva actividad</a></li>
                                <li class="nav-divider"></li>
                                <li><a href="{{ url('/classrooms') }}"><i class="fa fa-navicon"></i>  Salones</a></li>
                                <li class="nav-divider"></li>
                                <li><a href="{{ url('/tutors') }}"><i class="fa fa-user"></i>  Profesores</a></li>
                                <li class="nav-divider"></li>
                                <li><a href="{{ url('/classes') }}"><i class="fa fa-calendar-o"></i>  Clases/Horarios</a></li>

                            </ul>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-briefcase"></i>  Gestión <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/products') }}"><i class="fa fa-barcode "></i>  Productos</a></li>
                                <li><a href="{{ url('/sales') }}"><i class="fa fa-shopping-cart"></i>  Nueva venta</a></li>
                                <li class="nav-divider"></li>
                                <li><a href="{{ url('/inscriptions') }}"><i class="fa fa-pencil-square-o"></i>  Inscripciones</a></li>
                                <li class="nav-divider"></li>
                                <li><a href="{{ url('/tasks') }}"><i class="fa fa-tasks"></i>  Tareas </a></li>
                                <li class="nav-divider"></li>
                                <li><a href="{{ url('/statistics') }}"><i class="fa fa-bar-chart"></i>  Estadisticas</a></li>
                                <li class="nav-divider"></li>
                                <li><a href="{{ url('/new_user_roles') }}"><i class="fa fa-user-plus "></i>  Agregar usuarios</a></li>

                            </ul>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-cog"></i>  Contenidos<span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/notifications') }}"><i class="fa fa-bell"></i>  Notificaciones</a></li>
                                <li class="nav-divider"></li>
                                <li><a href="{{ url('/categories') }}"><i class="fa fa-tags"></i>  Categorías</a></li>
                                <li class="nav-divider"></li>
                                <li><a href="{{ url('/news') }}"><i class="fa fa-newspaper-o "></i>  Novedades</a></li>
                                <li class="nav-divider"></li>
                                <li><a href="{{ url('/quizzes') }}"><i class="fa fa-list-alt"></i>  Encuestas/Trivias</a></li>
                                <li class="nav-divider"></li>
                                <li><a href="{{ url('/benchmarks') }}"><i class="fa fa-trophy"></i>  Benchmarks</a></li>
                                <li class="nav-divider"></li>
                                <li><a href="{{ url('/wods') }}"><i class="fa fa-bookmark"></i>  WOD</a></li>

                            </ul>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-inbox"></i>  Gestión de Cajas<span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/cash_deposits') }}"><i class="fa fa-envelope"></i>  Depósitos de caja</a></li>
                                <li><a href="{{ url('/cash_transactions') }}"><i class="fa fa-retweet"></i>  Transacciones</a></li>
                                <li><a href="{{ url('/cashier_closing') }}"><i class="fa fa-usd "></i>  Cierres de caja</a></li>
                                <li class="nav-divider"></li>
                                <li><a href="{{ url('/type_cash_transactions') }}"><i class="fa fa-plus "></i>  Tipos de Trasaccíones</a></li>
                            </ul>
                        </li>
                    </ul>

                    <!--ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-laptop"></i>  Recepción<span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/site/get_tasks/user') }}"><i class="fa fa-user"></i>  Mi Perfil</a></li>
                                <li class="nav-divider"></li>
                                <li><a href="{{ url('/cash_transactions') }}"><i class="fa fa-credit-card"></i>  Ventas</a></li>
                                <li class="nav-divider"></li>
                                <li><a href="{{ url('/cashier_closing') }}"><i class="fa fa-calendar-plus-o"></i>  Planes</a></li>
                                <li class="nav-divider"></li>
                                <li><a href="{{ url('/cashier_closing') }}"><i class="fa fa-book"></i>  Deudas</a></li>
                                <li class="nav-divider"></li>
                                <li><a href="{{ url('/cashier_closing') }}"><i class="fa fa-users"></i>  Clientes</a></li>
                                <li class="nav-divider"></li>
                                <li><a href="{{ url('/type_cash_transactions') }}"><i class="fa fa-address-book"></i>  Empleados</a></li>
                            </ul>
                        </li>
                    </ul-->


                    @endif
                    @endif

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

    @yield('content')
</div>

<!-- Scripts -->

{{ Html::script('vendors/ckeditor/ckeditor.js') }}
{{ Html::script('vendors/ckeditor/adapters/jquery.js') }}
<!--script src="{{ asset('js/app.js') }}"></script-->
<script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
