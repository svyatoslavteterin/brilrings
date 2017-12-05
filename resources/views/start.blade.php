<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
          @include('layouts.head')


    </head>
    <body>

<div class="container">


</div>




      @include('layouts.header')

      @include('layouts.top')
        @yield('content')

      @include('layouts.guests')


      @include ('layouts.footer')

      <script type="text/javascript" src="/js/app.js"></script>
      <script type="text/javascript" src="/js/scripts.js"></script>

      <script type="text/javascript">
        $('.carousel').carousel({
            interval: 5000 //changes the speed
        });
      </script>
    </body>
</html>
