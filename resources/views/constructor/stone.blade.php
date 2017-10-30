
@extends('layout')


@section('content')
<div class="steps">
<div class="container">
  <nav>
    <ul>
      <li class="active">
        <a href="#"><span>Этап №1 <span>Выбрать оправу</span></span></a>
      </li>
      <li>
        <a href="#"><span>Этап №2 <span>Выбрать камень</span></span></a>
      </li>
      <li>
        <a href="#"><span>Этап №3 <span>Завершить кольцо</span></span></a>
      </li>
    </ul>
  </nav>
</div>
</div>
<div id="app">

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
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
@endsection
