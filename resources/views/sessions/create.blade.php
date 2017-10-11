@extends('inside')



@section('content')
<div class="container" style="width:50%;">
<form class="form" action="/ring_sessions" method="post">
  {{csrf_field()}}
        <h2 class="form-signin-heading">Добавление сессии</h2>
        <hr>
        <div class="form-group">
          <label for="inputContents" class="sr-only">Содержимое</label>
          <textarea name="contents" required autofocus placeholder="Введите данные" class="form-control"></textarea>
        </div>
        <div class="form-group">
          <button class="btn btn-lg btn-primary btn-block" type="submit">Отправить</button>
        </div>
      </form>
</div>
@endsection
