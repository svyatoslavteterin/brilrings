<template>


      <div class="options__item" :class="optionKey" v-if="optionTemplate==='imagebox'">

          <h3 class="options__item__title">{{ringOption.title}}</h3>
        <ul>


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
          <div class="options__item " :class="optionKey" v-else-if="optionTemplate==='imageslider'">
          <h3 class="options__item__title">{{ringOption.title}}</h3>

            <div class="jcarousel-wrapper">
              <a href="#" class="jcarousel-prev" @click.prevent="prevImg"></a>
            <div class="jcarousel">



                <ul>


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
                  <a href="#" class="jcarousel-next" @click.prevent="nextImg"></a>
                </div>


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
                              :option-key="optionKey"
                              :key="optionKey"
                              >
              </ringoptionvalue>
              </select>

            </div>


            <div v-else-if="optionTemplate==='range'" class="options__item col-sm-3 col-xs-3 col-md-12">
                  <h3 class="options__item__title">{{ringOption.title}}</h3>
                  <div class="range-slider">
                     <input class="uk-range" type="range"  :id="'range'+optionKey" value="value" step="1" min="1" :max="ringOptionValues[optionKey].length"  v-model="value" @change="update(value)" />
                     <p class="option-range-label" v-text="getOptionValueTitle.title" :style="{'left':getLabelLeft+'%'}"> </p>
                 </div>
            </div>
</template>

<script>
    module.exports = {
    methods: {

      nextImg:function(){
          $('.jcarousel').jcarousel('scroll', '+=1');
      },
      prevImg:function(){
            $('.jcarousel').jcarousel('scroll', '-=1');
      },

      add:function(){


      },
      update:function(newValue){
        console.log("update "+this.optionKey);
          this.value=parseInt(newValue);
          store.commit('setOption',{'value':newValue,'optionKey':this.optionKey});
        }
      },

        data:function(){


            return  {
              value: 1
            };
          },

        props:['ringOptions','active','ringOptionValues','option','optionKey'],

        ready: function () {


        },
        mounted:function(){




        },
        created:function(){
          if (this.optionKey=="material") this.value=ringMaterial;
          if (this.optionKey=="base") this.value=ringBase;
          if (this.optionKey=="weight") this.value=8;
          if (this.optionKey=="size") this.value=8;
          if (this.optionKey=="purity") this.value=4;
          if (this.optionKey=="color") this.value=3;





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
                if (left==0) left=3;
                if (left>50 && left<100) left-=3;
                if (left==100) left-=6;
                return left;
              }

        }
    }
</script>
