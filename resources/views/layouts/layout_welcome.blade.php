<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Forkbomb</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <style>
        canvas{
          canvas { width: 30%; height: 30% }
        }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a title = "Select Vehicle Model Here" href="{{ url('/select') }}">Start Simulating</a>
                    @else
                        <a title = "Existing Users Login Here" href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a title = "New Users Register Here" href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
              <div class="">
                @yield('logo')
              </div>
                <div class="title-small m-b-md" style="margin-top:50px;">
                  @yield('title')
                    <!-- Laravel -->
                </div>
                <div>
                  <div class="">@yield('model_background')</div>
                  <div class="">@yield('render_window')</div>
                </div>
                <div>
                  @yield('image_gallery')
                </div>
                <div class="links">
                  @yield('links')
                    <!-- <a href="https://laravel.com/docs">Docs</a>-->
                </div>
            </div>
        </div>
    </body>
</html>
