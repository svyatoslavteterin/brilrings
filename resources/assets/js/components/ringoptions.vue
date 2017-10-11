<template>
    <div class="options">


        <ul  v-for="ringOption in ringOptions" :key="ringOption.id">
          <ringoption  :ringOption="ringOption" :value="ringOption.value" ></ringoption>

        </ul>


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

        props:['ringOptions'],

        ready: function () {



        },
        mounted:function(){

        },



        computed: {

        }
    }
</script>
