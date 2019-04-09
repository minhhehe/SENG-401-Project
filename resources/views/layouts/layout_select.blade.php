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
        <link href="{{ asset('css/transition.css') }}" rel="stylesheet">

        <!-- Scripts  -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="{{ asset('js/swup.min.js') }}"></script>
        <!-- TODO Dirty hardcoding. Move into JS file -->
        @yield('script')
    </head>
    <body>
        <div class="flex-center position-ref full-height">
          <div class="top-left links">
            <a class="navbar-brand" href="{{ url('/') }}">
                <!-- {{ config('app.name', 'Laravel') }} -->
                CADA Realistic Automotive Project
            </a>
          </div>
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Your Account</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
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
        </div>
        <script type="text/javascript">
            const swup = new Swup();
        </script>
    </body>
</html>
