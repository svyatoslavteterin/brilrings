@extends('start')


@section('content')

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

    'center': {
      'options':[
        {
          'material':'imagebox',

        },
        {
          'material':'selectbox'
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
 window.baseurl='/';
var ringBase={{{ isset($base) ? $base : 1 }}};
var ringMaterial={{{ isset($material) ? $material : 2 }}};
activeStep="start";
</script>

@endsection
