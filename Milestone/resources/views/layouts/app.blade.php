<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token-->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>EPortfolio</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <style>

     </style>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body style='
 background-image: linear-gradient(black,blue, grey); 
  height: 100vh; width: 100%; object-fit: contain'>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-dark shadow-sm border border-warning">
            <div class="container">
            <!--  -->
                <a style="color: white" class="navbar-brand" href="{{ url('/') }}">
                   <h4>EPortfolio</h4>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon" class="d-block p-2 bg-primary text-white"></span>
                </button>
				
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    <a style="color: white" class="navbar-brand" href="{{ url('/') }}">
						<img src="../resources/assets/logo.jpg" width="100px" height="100px">
						</a>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @if (session()->get('user'))
                        <li class="nav-item border border-light rounded-pill">
                                <a style="color: white" class="nav-link" href="account">Account</a>
                        </li>
                        <li class="nav-item border border-light rounded-pill">
                                <a style="color: white" class="nav-link" href="logout">Log Out</a>
                        </li>
                        <li class="nav-item border border-light rounded-pill">
                                <a style="color: white" class="nav-link" href="home">Home</a>
                        </li>
                        @else
                            <li class="nav-item border border-light rounded-pill">
                                <a style="color: white" class="nav-link" href="login">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item border border-light rounded-pill">
                                <a style="color: white" class="nav-link" href="register">{{ __('Register') }}</a>
                            </li>
                        @endif
                        @if (session()->get('isAdmin'))
                        	<li class="nav-item border border-light rounded-pill">
                                <a style="color: white" class="nav-link" href="admin">Admin Page</a>
  						@endif
                    </ul>
                </div>
                <!--  -->
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
<footer><h6 align="center" style="color: white">Copyright @2021 EPortfolio</h6></footer>
</html>
