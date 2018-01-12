@extends('inside')

@section('title')


  <h2 class="pagetitle">{{$pagetitle}}</h2>
@endsection

@section('content')

<div class="row">
  <div class="col-md-12">


    </div>
</div>


<div class="row for-her">

  <gift  v-for="gift in gifts" :key="gift.id" :gift-option-values="{{$gift_option_values }}" :gift-options="{{$gift_options }}" :data="gift" ref="gift"> </gift>



</div>
@endsection
