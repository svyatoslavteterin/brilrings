<template>
    <div class="options">



    </div>

</template>

<script>
    module.exports = {
    methods: {
      chooseOption: function () {
        console.log('hello from mixin!');
      }
      },

      data() {
        return {
          field: '',
          options: this.initialOptions
        }
        },

        props:['options'],

        ready: function () {



        },
        mounted:function(){
        
        },



        computed: {

        }
    }
</script>
