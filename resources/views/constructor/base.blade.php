
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

  <steps
  :s-ring-options="ringOptions"
  :steps-list="steps"
  :s-ring-option-values="ringOptionValues"
  ref="steps"

  >

  </steps>

  <!-- use the modal component, pass in the prop -->
   <modal v-if="showModal.save" @close="showModal.save = false">
     <!--
       you can use custom content here to overwrite
       default content
     -->
     <h3 slot="header">Сохранить на почту</h3>
     <div  slot="body">
       <form name="save" action="/savetoemail" method="post" @submit.prevent="saveToEmail" id="savetoemail-form">
           {{csrf_field()}}
         <div class="form-group">
            <input type="text" name="name" value="" placeholder="Имя" />

         </div>
          <div class="form-group">
            <input type="text" name="email" value="" placeholder="Email" />
          </div>
           <div class="form-group">
             <input type="text" name="phone" value="" placeholder="Телефон" />
          </div>
          <div class="form-group">
            <button type="submit" name="submit">Отправить</button>
         </div>

       </form>
     </div>

   </modal>

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
        'blocks':['result-img','ring-images']
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

@endsection
