<template>
    <div class="steps">
        <div v-for="ringOptions in steps" class="steps__item">
          <ringoptions :ringOptions="ringOptions"></ringoptions>
        </div>

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
              steps:[]
            };
          },

        props:['steps'],

        ready: function () {

          console.log(this.steps);

        },
        mounted:function(){
          axios.get('/ring_options').then(response=>this.steps=response.data);

        },



        computed: {

        }
    }
</script>
