@extends('start')


@section('content')

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

    'center': {
      'options':[
        {
          'material':'imagebox',
        },
        {
          'base':'card'
        }
      ],
      'blocks':['result-img']
    },
    'template':'start'
  }

];
var ringBase={{{ isset($base) ? $base : 1 }}};
var ringMaterial={{{ isset($material) ? $material : 1 }}};

</script>
  
@endsection
