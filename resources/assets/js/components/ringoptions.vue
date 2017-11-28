<template>
    <div class="options">



          <ringoption
          :option="value"
          v-for="(value,key,index)  in options"
          :ring-options="ringOptions"
          :ring-option-values="ringOptionValues"
          :option-key="value"
          :key="index"
          ref="ringoption"
          >
          </ringoption>




    </div>

</template>

<script>
    module.exports = {
    methods: {

      },

      data() {


        return {
          field: '',
        }
        },

        props:['options','ringOptions','ringOptionValues'],

        ready: function () {



        },
        mounted:function(){

        },



        computed: {

        }
    }
</script>
