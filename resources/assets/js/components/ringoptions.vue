<template>
    <div class="options">



          <ringoption :option="option" v-for="(option,key,index)  in options" :ring-options="ringOptions"
          :ring-option-values="ringOptionValues" :option-key="option"></ringoption>




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
