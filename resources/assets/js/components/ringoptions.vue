<template>
    <div class="options">



          <ringoption
          :option="value"
          v-for="(value,key,index)  in options"
          :ring-options="ringOptions"
          :ring-option-values="ringOptionValues"
          :store="store"
          :option-key="value"
          :key="index"
          ref="ringoption"
          :params="params"
          >
          </ringoption>




    </div>

</template>

<script>
    module.exports = {
    methods: {

      },

      data:function(){


          return  {
            field: '',
            params:
                {
                  material:window.ringMaterial,
                  base:window.ringBase,
                  weight:window.ringWeight,
                  size:window.ringWeight,
                  purity:4,
                  color:window.ringColor
                }




          }
        },

        props:['options','ringOptions','ringOptionValues','store'],

        ready: function () {



        },
        mounted:function(){

        },



        computed: {

        }
    }
</script>
