<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Briliant Rings</title>


        <link href="https://file.myfontastic.com/uJGzALvzUvuwHW9GWF4MB3/icons.css" rel="stylesheet">

        <link  type="text/css" rel="stylesheet" href="/css/app.css" />


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
