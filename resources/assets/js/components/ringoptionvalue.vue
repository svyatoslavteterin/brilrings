<template>


            <li v-if="optionTemplate=='imageslider'" :class="{ active: isActive }"><a href="#" @click.prevent="chooseOption">

              <img src="/resultimage/12421412.jpg" width="140" height="70" :title="ringOptionValue.title"/>
            </a></li>

            <li v-else-if="optionTemplate=='imagebox'" :class="{ active: isActive }"><a href="#" @click.prevent="chooseOption"></a></li>
            <option v-else-if="optionTemplate==='selectbox'" :value="ringOptionValue.value">{{ringOptionValue.title}}</option>
            <input v-else-if="optionTemplate==='text'" value="text">
            <div v-else-if="optionTemplate==='card'"> </div>
            <div v-else-if="optionTemplate==='switch'">{{ringOptionValue.title}}</div>



</template>


<script>
    module.exports = {
    methods: {
      chooseOption: function () {

        this.$emit('choose',this.value);
      },
      update:function(){


      }
      },

        data:function(){
            return  {
              optionTemplate:this.optionTemplateValue,

              value:parseInt(this.ringOptionValue.value)

            };
          },

        props:['ringOptionValue','optionTemplateValue','optionCount','optionKey'],

        ready: function () {



        },
        mounted:function(){

        },



        computed: {

          isActive:function(){
            if (this.value===store.state.session[this.optionKey]){
              return true;
            }
          },
          isSelected:function(){
            return true;
          }

        }
    }
</script>
