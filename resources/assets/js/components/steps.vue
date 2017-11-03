<template>


  <div>

        <div v-for="(step,key,index) in stepsList" class="steps__item " :class="{active:isActive(step.template)}" >


                <div v-if="step.template==='start'" class="container" :class="step.template" >
                      <ringoptions :options="step.center.options" :ring-options="SRingOptions" :ring-option-values="SRingOptionValues"></ringoptions>
                </div>

              <div v-if="step.template==='base'" class="container" :class="step.template" >
                  <div class="row">
                    <div class="col-sm-12 col-md-2 left-col">
                        <ringoptions :options="step.left.options" :ring-options="SRingOptions" :ring-option-values="SRingOptionValues"></ringoptions>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 center-col" >
                      <ringblocks :blocks="step.center.blocks" ref="blocks"></ringblocks>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-4 right-col">
                          <ringblocks :blocks="step.right.blocks" ref="blocks" :ring-option-values="SRingOptionValues"></ringblocks>
                        <ringoptions :options="step.right.options" :ring-options="SRingOptions" :ring-option-values="SRingOptionValues"></ringoptions>

                        <p class="price"><span v-text="getTotalPrice"></span></p>

                        <button @click="nextStep('stone')" class="btn btn-primary">Выбрать</button>  <button class="btn btn-default">Помощь специалиста</button>
                    </div>
                  </div>
              </div>
              <div v-if="step.template==='stone'" class="container" :class="step.template">
                <div class="row">
                  <div class="col-sm-12 col-md-3 left-col">
                      <ringoptions :options="step.left.options" :ring-options="SRingOptions" :ring-option-values="SRingOptionValues"></ringoptions>
                  </div>
                  <div class="col-xs-6 col-sm-6 col-md-5 center-col">
                        <ringblocks :blocks="step.center.blocks" ref="blocks"></ringblocks>
                  </div>
                  <div class="col-xs-6 col-sm-6 col-md-4 right-col">


                        <ringblocks :blocks="step.right.blocks" ref="blocks" :ring-option-values="SRingOptionValues"></ringblocks>
                        <p>Итоговая цена:</p>
                        <p><span v-text="getTotalPrice" class="price"></span> </p>
                          <button @click="nextStep('result')" class="btn btn-primary">Выбрать</button>  <button class="btn btn-default">Помощь специалиста</button>
                  </div>
                </div>
              </div>
              <div v-if="step.template==='result'" class="container" :class="step.template">
                  <div class="col-xs-6 col-sm-6 col-md-8 center-col">
                    <ringblocks :blocks="step.center.blocks" ref="blocks"></ringblocks>
                  </div>
                  <div class="col-xs-6 col-sm-6 col-md-4 right-col">
                        <ringblocks :blocks="step.right.blocks" ref="blocks"></ringblocks>


                            <button class="btn btn-default btn-how-to-know">Как узнать размер?</button>
                        <p>Размер кольца</p>
                        <ringoptions :options="step.right.options" :ring-options="SRingOptions" :ring-option-values="SRingOptionValues"></ringoptions>
                          <p><span v-text="getTotalPrice" class="price"></span> </p>
                        <div class="action-btns">
                          <button class="btn btn-primary btn-order">Заказать</button>
                          <span>или</span>
                          <button class="btn btn-primary btn-handmade">Сделать своими руками</button>
                        </div>
                        <button class="btn btn-default btn-help">Помощь специалиста</button>
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
        nextStep:function(step){
          console.log(step);
            store.state.step=step;
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
