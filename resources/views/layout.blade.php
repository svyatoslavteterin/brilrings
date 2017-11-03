<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
            @include('layouts.head')
    </head>
    <body>

<div class="container">


</div>




      @include('layouts.header2')



        @yield('content')



      @include ('layouts.footer')
      <script type="text/javascript" src="/js/app.js"></script>
      <script type="text/javascript" src="/js/scripts.js"></script>


    </body>
</html>
