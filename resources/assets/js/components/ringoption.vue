<template>


      <div class="options__item">
        <ul v-if="optionTemplate==='imagebox'">


            <ringoptionvalue v-for="ringOptionValue in ringOptionValues[optionKey]"
                            :ring-option-value="ringOptionValue"
                            :option-template="optionTemplate">
            </ringoptionvalue>



        </ul>





          <select v-else-if="optionTemplate==='selectbox'">
            <ringoptionvalue v-for="ringOptionValue in ringOptionValues[optionKey]"
                            :ring-option-value="ringOptionValue"
                            :option-template="optionTemplate">
            </ringoptionvalue>
            </select>

            <div v-else-if="optionTemplate==='range'||optionTemplate==='text'||optionTemplate==='switch'">
                <ringoptionvalue v-for="ringOptionValue in ringOptionValues[optionKey]"
                                :ring-option-value="ringOptionValue"
                                :option-template="optionTemplate">
                </ringoptionvalue>
            </div>
        </div>
</template>

<script>
    module.exports = {
    methods: {
      chooseOption: function () {

      }
      },

        data:function(){


            return  {
              active:2,
              option:this.option
            };
          },

        props:['ringOptions','active','option','ringOptionValues','option'],

        ready: function () {



        },
        mounted:function(){



        },
        created:function(){

          var optionValue={};


        //   var optionId=this.ringOptions[this.option].id;

          //  alert(this.ringOptions.base.id);
            //this.optionValues=this.ringOptionValues[optionId];

        },

        computed: {
              optionKey:function(){
                for (var prop in this.option) {
                  return prop;
                }
              },
              optionTemplate:function(){
                for (var prop in this.option) {
                  return this.option[prop];
                }
              }
        }
    }
</script>
