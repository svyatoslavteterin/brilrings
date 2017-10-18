<template>


            <li v-if="optionTemplate=='imageslider'"><a href="#" @click.prevent="update">

              <img src="/resultimage/12421412.jpg" width="140" height="70" :title="ringOptionValue.title"/>
            </a></li>

            <li v-else-if="optionTemplate=='imagebox'"><a href="#" @click.prevent="selectOption"></a></li>
            <option v-else-if="optionTemplate==='selectbox'">{{ringOptionValue.title}}</option>
            <input v-else-if="optionTemplate==='text'" value="text">
            <div v-else-if="optionTemplate==='card'"> </div>
            <div v-else-if="optionTemplate==='switch'">{{ringOptionValue.title}}</div>



</template>


<script>
    module.exports = {
    methods: {
      selectOption: function () {
        this.$emit('selectOption',this.value);
      },
      update:function(){

          this.$emit('value', this.value);
      }
      },

        data:function(){
            return  {
              optionTemplate:this.optionTemplateValue,
              session:{'base':3},
              value:this.ringOptionValue.value
            };
          },

        props:['ringOptionValue','optionTemplateValue','optionCount'],

        ready: function () {



        },
        mounted:function(){

        },



        computed: {
          rangeLabel:function(optionKey){
            return this.optionValues[optionKey][this.value].title;
          }

        }
    }
</script>
