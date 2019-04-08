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
        <link href="{{ asset('css/transitions.css') }}" rel="stylesheet">
        <script src="{{ asset('js/swup.min.js') }}"></script>

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/select') }}">Start Simulating</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
              <div id = "swup" class="transition-fade">
                @yield('logo')
              </div>
                <div id = "swup" class="title m-b-md transition-fade">
                  @yield('title')
                    <!-- Laravel -->
                </div>
                <div class="links">
                  @yield('links')
                    <!-- <a href="https://laravel.com/docs">Docs</a>-->
                </div>
            </div>
        </div>
      <script type="text/javascript"> const swup = new Swup(); </script>
    </body>
</html>
