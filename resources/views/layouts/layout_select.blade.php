<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CADA Realistic Automotive Project</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <style>
            /* TODO Dirty hardcoding. Move into CSS file */
            .card {
                border:2px solid #ccc;
                border-radius: 2px;

                width: 250px;
                height: 180px;

                display: inline-block;
            }

            .card-image {
                /*
                width: 100%;
                display: block;
                margin-left: auto;
                margin-right: auto;
                */

                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        </style>

        <!-- Scripts  -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript">
            // TODO Dirty hardcoding. Move int JS file
            @yield('script')
        </script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
              <div class="">
                  <!-- The entity to display with the most attention -->
                @yield('mainDisplay')
              </div>
                <div class="">
                    <!-- The list of content options -->
                  @yield('list')
                </div>
            </div>
        </div>
    </body>
</html>
