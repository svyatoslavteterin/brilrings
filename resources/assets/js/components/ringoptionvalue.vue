<template>

            <div v-if="optionTemplate==='range'">{{ringOptionValue.title}}</div>
            <li v-else-if="optionTemplate=='imagebox'"><a href="#">{{ringOptionValue.title}}</a></li>
            <option v-else-if="optionTemplate==='selectbox'">{{ringOptionValue.title}}</option>
            <input v-else-if="optionTemplate==='text'" value="text">
            <div v-else-if="optionTemplate==='switch'">{{ringOptionValue.title}}</div>



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
              optionTemplate:this.optionTemplate

            };
          },

        props:['ringOptionValue','optionTemplate'],

        ready: function () {



        },
        mounted:function(){

        },



        computed: {

        }
    }
</script>
