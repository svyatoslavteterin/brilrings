<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
      <link href="https://file.myfontastic.com/uJGzALvzUvuwHW9GWF4MB3/icons.css" rel="stylesheet">

        <link  type="text/css" rel="stylesheet" href="/css/app.css" />


    </head>
    <body>

<div class="container">


</div>


      <div id="app">

        <steps :steps-list="steps"
        :s-ring-options="ringOptions"
        :s-ring-option-values="ringOptionValues"
        ref="steps"
        >

        </steps>


      </div>

      @include('layouts.header')
      @include('layouts.top')
        @yield('content')

      @include('layouts.guests')
      @include ('layouts.footer')

      <script type="text/javascript" src="/js/app.js"></script>
      <script type="text/javascript" src="/js/scripts.js"></script>

    </body>
</html>
