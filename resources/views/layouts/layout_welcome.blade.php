<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>FK BS 2019</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
          <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}" defer></script>
        <style>
        canvas{
          canvas { width: 30%; height: 30% }
        }
        </style>
    </head>
    <body>
      <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <!-- Left Side Of Navbar -->
        <a class="navbar-brand" href="{{ url('/') }}">
            <!-- {{ config('app.name', 'Laravel') }} -->
            FKBmb Background Simulator 2019
        </a>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/select">Select a Model</a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="{{ url('/render_model/1') }}">Backround</a>
            </li> -->
        </ul>

          <div class="container">
            <div class="navbar-brand" style="text-align: center;margin-left:15%;font-style:italic;">@yield('title')</div>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                  <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <!-- Right Side Of Navbar -->
                  <ul class="navbar-nav ml-auto">
                      <!-- Authentication Links -->
                      @guest
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                          </li>
                          @if (Route::has('register'))
                              <li class="nav-item">
                                  <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                              </li>
                          @endif
                      @else
                          <li class="nav-item dropdown">
                              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                  {{ Auth::user()->fname }} {{ Auth::user()->lname}} <span class="caret"></span>
                              </a>

                              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('/home') }}">Your Account<a>
                                  <div class="h-divider"></div>
                                  <a class="dropdown-item" href="{{ route('logout') }}"
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

            <div class="content">
              <div class="">
                @yield('logo')
              </div>
                <div class="title-small m-b-md" style="margin-top:50px;">
                  @yield('title')
                    <!-- Laravel -->
                </div>
                <div>
                  <div class="background">@yield('model_background')</div>
                  <div class="">@yield('render_window')</div>
                </div>
                <div class="search">
                  @yield('image_gallery')
                </div>
                <div class="links">
                  @yield('links')
                    <!-- <a href="https://laravel.com/docs">Docs</a>-->
                </div>
            </div>

    </body>
</html>
