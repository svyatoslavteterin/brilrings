
@extends('layout')


@section('content')
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
          'shape':'selectbox'
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
      'options':[
        {
          'fsize':'selectbox'
        }
      ]
    },
    'template':'result'
  }
];

window.baseurl='/constructor/base/';
window.ringBase={{{ isset($base) ? $base : 1 }}};
window.ringMaterial={{{ isset($material) ? $material : 2 }}};
window.ringShape={{{ isset($shape) ? $shape : 1 }}};
window.ringWeight={{{ isset($weight) ? $weight : 8 }}};
window.ringColor={{{ isset($color) ? $color : 3 }}};
window.ringStone={{{ isset($stone) ? $stone : 1 }}};

activeStep="base";

</script>

<div id="app">


  <div class="steps">
  <div class="container">
    <nav class="hidden-xs">
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
    <select class="visible-xs" v-model="step" @change="nextStep(step)">
      <option value="base" >Этап №1:Выбрать оправу</option>
      <option value="stone" >Этап №2:Выбрать камень</option>
      <option value="result" >Этап №3:Завершить кольцо</option>
    </select>
  </div>
  </div>
@include('layouts.modals')
  <steps
  :s-ring-options="ringOptions"
  :steps-list="steps"
  :s-ring-option-values="ringOptionValues"
  ref="steps"

  >

  </steps>






</div>







@endsection


@section('footer')



@endsection
