<template>
    <div class="ringoptionvalues">

      <li v-for="ringOptionValue in ringOptionValues" :key="ringOptionValue.id" >

              <ringoptionvalue


                                :ringOptionValue="ringOptionValue"
                                :ringOption="ringOption">
                                :active.sync="active"
                                </ringoptionvalue>

        </li>
    </div>
</template>

<script>
    module.exports = {
    methods: {
      chooseOption: function () {
        console.log('hello from mixin!');
      }
      },

        data:function(){
            return  {
              ringOptionValues:{},
              active:{'fdsfsd':2}
            };
          },

        props:['ringOption','active'],

        ready: function () {



        },
        mounted:function(){
          axios.get('/ring_options/'+this.ringOption.id+'/values').then(response=>this.ringOptionValues=response.data);

        },



        computed: {

        }
    }
</script>
