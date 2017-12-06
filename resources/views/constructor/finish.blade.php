
@extends('layout')


@section('content')
<div class="steps">
<div class="container">
  <nav>
    <ul>
      <li >
        <a href="#" data-step="base"><span>Этап №1 <span>Выбрать оправу</span></span></a>
      </li>
      <li >
        <a href="#" data-step="stone"><span>Этап №2 <span>Выбрать камень</span></span></a>
      </li>
      <li class="active">
        <a href="#" data-step="finish"><span>Этап №3 <span>Завершить кольцо</span></span></a>
      </li>
    </ul>
  </nav>
</div>
</div>
<div id="app">
@include('layouts.modals')
  <steps :steps-list="steps"
  :s-ring-options="ringOptions"
  :s-ring-option-values="ringOptionValues"
  ref="steps"
  >

  </steps>


</div>



@endsection


@section('footer')

<script type="text/javascript">
  steps=[
    {
    'left':{
      'options':[
        {
          'base':'imageslider'
        }
      ],
    },
    'center': {
      'blocks':['result-img']
    },
    'right':{
      'options':[
        {
          'material':'selectbox'
        },
        {
          'stone':'selectbox'
        }
      ],
      'blocks':['info']
    },
    'template':'base'
  },
  {
    'left':{
      'options':[
        {
          'shape':'imagebox'
        },
        {
          'weight':'range'
        },
        {
          'size':'range'
        },
        {
          'color':'range'
        },
        {
          'purity':'range'
        }
      ]
    },
    'center':{
      'blocks':['result-img']
    },
    'right':{
      'blocks':['result-table']
    },
    'template':'stone'

  },
  {
    'center':{
      'blocks':['result-img','thumb-img']
    },
    'right':{
      'blocks':['result-table'],
      'options':[{'fsize':'range'}]
    },
    'template':'result'
  }
];


</script>

@endsection
