<template>


      <div class="options__item" :class="optionKey" v-if="optionTemplate==='imagebox'||optionTemplate==='imageslider'">

          <h3 class="options__item__title">{{ringOption.title}}</h3>
        <ul >


            <ringoptionvalue v-for="ringOptionValue in ringOptionValues[optionKey]"
                            :ring-option-value="ringOptionValue"
                            :option-template-value="optionTemplate"
                            :key="optionKey"
                            :option-key="optionKey"
                            v-on:choose="update"


                            >
            </ringoptionvalue>



        </ul>

        </div>
        <div class="options__item" :class="optionKey" v-else-if="optionTemplate==='card'">


          <div class="cards-container">

              <div class="row">
                <ringoptionvalue v-for="ringOptionValue in ringOptionValues[optionKey]"
                                :ring-option-value="ringOptionValue"
                                :option-template-value="optionTemplate"
                                :key="optionKey"
                                :option-key="optionKey"
                                v-on:choose="update"


                                >
                </ringoptionvalue>
              </div>


          </div>

          </div>


          <div class="options__item" :class="optionKey" v-else-if="optionTemplate==='selectbox'">
            <select class="uk-select" v-model="value" @change="update(value)">
              <ringoptionvalue v-for="ringOptionValue in ringOptionValues[optionKey]"
                              :ring-option-value="ringOptionValue"
                              :option-template-value="optionTemplate"
                              :key="optionKey"
                              >
              </ringoptionvalue>
              </select>

            </div>


            <div v-else-if="optionTemplate==='range'" class="options__item">
                  <h3 class="options__item__title">{{ringOption.title}}</h3>
                  <div class="range-slider">
                     <input class="uk-range" type="range"  step="1" min="1" :max="ringOptionValues[optionKey].length" value="1" v-model="value" @change="update(value)" />
                     <p class="option-range-label" v-text="getOptionValueTitle.title" :style="{'left':getLabelLeft+'%'}"> </p>
                 </div>
            </div>
</template>

<script>
    module.exports = {
    methods: {


      add:function(){


      },
      update:function(newValue){

          this.value=newValue;
          store.commit('setOption',{'value':newValue,'optionKey':this.optionKey});
        }
      },

        data:function(){


            return  {
              value:1
            };
          },

        props:['ringOptions','active','ringOptionValues','option'],

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
              ringOption:function(){
                for (var prop in this.option) {
                  return this.ringOptions[prop];
                }
              },
              optionKey:function(){
                for (var prop in this.option) {
                  return prop;
                }
              },
              optionTemplate:function(){
                for (var prop in this.option) {
                  return this.option[prop];
                }
              },
              getOptionValueTitle:function(){
                for (var prop in this.option) {
                  return this.ringOptionValues[prop][this.value-1];
                }
              },
              countValues:function(){
                for (var prop in this.option) {
                  if (length=this.ringOptionValues[prop].length) return length;
                }
              },
              getLabelLeft:function(){
                left= (this.value-1)/(this.countValues-1)*100;
                return left;
              }
        }
    }
</script>
