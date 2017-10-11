<template>

            <a href="#" @click.prevent="selectOption">
                {{ringOptionValue.title}}
            </a>


</template>

<script>
    module.exports = {
    methods: {
      selectOption: function () {
        this.active=this.ringOptionValue;
        this.ringOptions.active=this.ringOptionValue;
      }
      },

        data:function(){
            return  {

            };
          },

        props:['ringOptionValue','ringOption','active'],

        ready: function () {



        },
        mounted:function(){

        },



        computed: {

        }
    }
</script>
