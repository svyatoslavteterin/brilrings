<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
      @include('layouts.head')

    </head>
    <body>





            @include('layouts.header2')

            <div class="container page-inside-topline">
              @yield('title')



            </div>

            <div class="container inside-page">
              <div id="app">

              @include('layouts.modals')
              




              </div>
        @yield('content')

          </div>

        @include ('layouts.footer')
        <script type="text/javascript" src="/js/app.js"></script>
        <script type="text/javascript" src="/js/scripts.js"></script>

    </body>
</html>
