
@extends('layout')


@section('content')

<div id="app">
  <div class="steps">
  <div class="container">
    <nav>
      <ul>
        <li :class="{active:isActive('base')}">
          <a @click.prevent="nextStep('base')"><span>Этап №1 <span>Выбрать оправу</span></span></a>
        </li>
        <li :class="{active:isActive('stone')}">
          <a @click.prevent="nextStep('stone')"><span>Этап №2 <span>Выбрать камень</span></span></a>
        </li>
        <li :class="{active:isActive('result')}">
          <a @click.prevent="nextStep('result')"><span>Этап №3 <span>Завершить кольцо</span></span></a>
        </li>
      </ul>
    </nav>
  </div>
  </div>
  <steps :steps-list="steps"
  :s-ring-options="ringOptions"
  :s-ring-option-values="ringOptionValues"
  ref="steps"
  >

  </steps>

@include('layouts.modals')
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
      'blocks':['ring-images','info']
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
        }

      ]
    },
    'center':{
      'blocks':['result-img']
    },
    'right':{
      'blocks':['stone-info']
    },
    'template':'stone'

  },
  {
    'center':{
      'blocks':['result-img']
    },
    'right':{
      'blocks':['info','result-table','stone-info'],
      'options':[{'fsize':'selectbox'}]
    },
    'template':'result'
  }
];

window.baseurl='/constructor/stone/';
window.ringBase={{{ isset($base) ? $base : 1 }}};
window.ringMaterial={{{ isset($material) ? $material : 2 }}};
window.ringShape={{{ isset($shape) ? $shape : 1 }}};
window.ringWeight={{{ isset($weight) ? $weight : 8 }}};
window.ringColor={{{ isset($color) ? $color : 3 }}};
window.ringStone={{{ isset($stone) ? $stone : 1 }}};

activeStep="stone";

</script>

@endsection
