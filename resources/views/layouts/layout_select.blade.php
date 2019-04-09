<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CRAP</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/transition.css') }}" rel="stylesheet">

        <!-- Scripts  -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="{{ asset('js/swup.min.js') }}"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <!-- TODO Dirty hardcoding. Move into JS file -->
        @yield('script')
    </head>
    <body>


        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a title = "Back To Homepage" class="navbar-brand" href="{{ url('/') }}">
                    <!-- {{ config('app.name', 'Laravel') }} -->
                    CADA Realistic Automotive Project
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a title = "Choose A Different Model"  class="nav-link" href="{{ url('/select') }}">Select a Model</a>
                        </li>
                        <li class="nav-item">
                            <a title = "Choose A Different Colour"  class="nav-link" href="{{ url('/render_model/1') }}">Colour</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a title = "New Users Register Here" class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a title = "Existing Users Login Here" class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a title = "User Information" id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->fname }} {{ Auth::user()->lname}} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                  <a title = "Access Your Account Information" class="dropdown-item" href="{{ url('/home') }}">Your Account<a>
                                    <div class="h-divider"></div>
                                    <a title = "Log Out - Goodbye!" class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- <div class="flex-center position-ref full-height"> -->
            <!-- TODO Verify safe to delete this commented block -->
            <!-- <div class="top-left links">
                <a class="navbar-brand" href="{{ url('/') }}">
                    CADA Realistic Automotive Project
                </a>
            </div> -->
            <!-- @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">John Smith</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif -->

            <div class="content" style="margin-top:18px;">
              <div id="swup" class="transition-fade">
              <div class="">
                  <!-- The entity to display with the most attention -->
                @yield('mainDisplay')
              </div>
            </div>
            <div id="swup" class="transition-fade">
                <div class="">
                    <!-- The list of content options -->
                  @yield('list')
                </div>
                  </div>
            </div>
        <!-- </div> -->
        <script type="text/javascript">
            const swup = new Swup();
        </script>
    </body>
</html>
