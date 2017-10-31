<template>


  <div>

        <div v-for="(step,key,index) in stepsList" class="steps__item " :class="{active:isActive(step.template)}" >


                <div v-if="step.template==='start'" class="container" :class="step.template" >
                      <ringoptions :options="step.center.options" :ring-options="SRingOptions" :ring-option-values="SRingOptionValues"></ringoptions>
                </div>

              <div v-if="step.template==='base'" class="container" :class="step.template" >
                  <div class="row">
                    <div class="col-md-2 left-col">
                        <ringoptions :options="step.left.options" :ring-options="SRingOptions" :ring-option-values="SRingOptionValues"></ringoptions>

                    </div>
                    <div class="col-md-6 center-col" >
                      <ringblocks :blocks="step.center.blocks" ref="blocks"></ringblocks>
                    </div>
                    <div class="col-md-4 right-col">
                          <ringblocks :blocks="step.right.blocks" ref="blocks" :ring-option-values="SRingOptionValues"></ringblocks>
                        <ringoptions :options="step.right.options" :ring-options="SRingOptions" :ring-option-values="SRingOptionValues"></ringoptions>

                        <p class="price"><span v-text="getTotalPrice"></span></p>

                        <button @click="nextStep" class="btn btn-primary">Выбрать</button>  <button class="btn btn-default">Помощь специалиста</button>
                    </div>
                  </div>
              </div>
              <div v-if="step.template==='stone'" class="container" :class="step.template">
                <div class="row">
                  <div class="col-md-4 left-col">
                      <ringoptions :options="step.left.options" :ring-options="SRingOptions" :ring-option-values="SRingOptionValues"></ringoptions>
                  </div>
                  <div class="col-md-5 center-col">
                        <ringblocks :blocks="step.center.blocks" ref="blocks"></ringblocks>
                  </div>
                  <div class="col-md-3 right-col">
                        <ringblocks :blocks="step.right.blocks" ref="blocks" :ring-option-values="SRingOptionValues"></ringblocks>
                  </div>
                </div>
              </div>
              <div v-if="step.template==='result'" class="container" :class="step.template">
                  <div class="col-md-8 center-col">
                    center
                  </div>
                  <div class="col-md-4 right-col">
                        <ringoptions :options="step.right.options" :ring-options="SRingOptions" :ring-option-values="SRingOptionValues"></ringoptions>
                  </div>

              </div>
        </div>

</div>
</template>

<script>
    module.exports = {
    methods: {
        update:function(){


        },
        nextStep:function(){
            console.log('next');
        },
        isActive:function(key){

          if (key===store.state.step){
            return true;
          }
        }
      },

        data:function(){
            return  {
              'active':'base'

            };
          },

        props:['stepsList','SRingOptions','SRingOptionValues'],

        ready: function () {


        },
        mounted:function(){


        },



        computed: {
          getTotalPrice:function(){
            return currencyFormatter.format(store.state.totalPrice, { code: 'RUB',precision:0});

          }

        }
    }
</script>
