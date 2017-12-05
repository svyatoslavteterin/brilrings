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

                        <p class="price"><span v-text="getBasePrice"></span></p>

                        <button @click="nextStep('stone')" class="btn btn-primary">Выбрать</button>  <button class="btn btn-default" @click="showModal('help-order1')">Помощь специалиста</button>
                    </div>
                  </div>
              </div>
              <div v-if="step.template==='stone'" class="container" :class="step.template">
                <div class="row">
                  <div class="col-sm-12 col-md-3 left-col">
                      <ringoptions :options="step.left.options" :ring-options="SRingOptions" :ring-option-values="SRingOptionValues" ref="ringoptions"></ringoptions>
                      <div class="color-desc" v-text="storeValue('color','desc')"> </div>
                  </div>
                  <div class="col-xs-6 col-sm-6 col-md-5 center-col">
                        <ringblocks :blocks="step.center.blocks" ref="blocks"></ringblocks>
                  </div>
                  <div class="col-xs-6 col-sm-6 col-md-4 right-col">

                    <h3 class="totalprice__title" v-text="storeValue('stone','title')"> </h3>
                      <p class="price"><span v-text="stonePrice"></span> </p>
                        <ringblocks :blocks="step.right.blocks" ref="blocks" :ring-option-values="SRingOptionValues"></ringblocks>
                        <p>Итоговая цена:</p>
                        <div class="stone-price-block" :class="'stone'+storeValue('stone','value')">
                          <div class="stone-price-block-item" @click="setOption('stone',1)" >С бриллиантом: <span v-text="getStonePrice(1)" class="price"></span> </div>
                          <div class="stone-price-block-item" @click="setOption('stone',2)" :class="{has:hasMussanit}">С муссанитом: <span v-text="getStonePrice(2)" class="price"></span> </div>
                        </div>
                          <button @click="nextStep('result')" class="btn btn-primary">Выбрать</button>  <button class="btn btn-default" @click="showModal('help-order2')">Помощь специалиста</button>
                  </div>
                </div>
              </div>
              <div v-if="step.template==='result'" class="container" :class="step.template">
                  <div class="col-xs-6 col-sm-6 col-md-8 center-col">
                    <ringblocks :blocks="step.center.blocks" ref="blocks"></ringblocks>
                  </div>
                  <div class="col-xs-6 col-sm-6 col-md-4 right-col">
                        <ringblocks :blocks="step.right.blocks" ref="blocks"></ringblocks>


                        <ringoptions :options="step.right.options" :ring-options="SRingOptions" :ring-option-values="SRingOptionValues"></ringoptions>
                            <a href="#" class="how-to-know">Как узнать размер?</a>

                          <p><span v-text="getTotalPrice" class="price"></span> </p>
                        <div class="action-btns">
                          <button class="btn btn-primary btn-order" @click.prevent="order()">Заказать</button>
                          <span>или</span>
                          <button class="btn btn-primary btn-handmade" @click.prevent="save()">Сохранить на почту</button>
                        </div>
                        <button class="btn btn-default btn-help" @click="showModal('help-order3')">Помощь специалиста</button>
                  </div>

              </div>
        </div>

</div>
</template>

<script>
    module.exports = {
    methods: {



      showModal:function(modal){
        RingApp.$modal.show(modal);
      },
      save:function(){
        RingApp.$modal.show('save-to-email');
      },
      order:function(){
          RingApp.$modal.show('ring-order');
      },
      getStonePrice:function(index){
        return currencyFormatter.format(store.state.stonePrice[index]+store.state.basePrice, { code: 'RUB',precision:0});
      },
        setOption:function(optionKey,value){
          store.commit('setOption',{optionKey:optionKey,value:value});
        },
      storeValue:function(optionKey,column){


        var optionvalue=store.state.session[optionKey];

        var ringOptionValues=RingApp.$data.ringOptionValues;


        var returnValue='';
        for (var i=0;i<ringOptionValues[optionKey].length;i++){
          if (ringOptionValues[optionKey][i].value==optionvalue){
            returnValue=ringOptionValues[optionKey][i][column];
            break;
          }
        }
        return returnValue;
      },
        update:function(){


        },
        nextStep:function(step){
            store.commit('setImage',{value:0})
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
          hasMussanit:function(){
            console.log(store.state.stonePrice[2]);
              if (store.state.stonePrice[2]>0){
                return true;
              }else{
                return false;
              }
          },
          getTotalPrice:function(){
            return currencyFormatter.format(store.state.totalPrice, { code: 'RUB',precision:0});

          },
          getBasePrice:function(){


            return currencyFormatter.format(store.state.basePrice, { code: 'RUB',precision:0});

          },
            stonePrice:function(){

              return currencyFormatter.format(store.state.stonePrice[store.state.session.stone], { code: 'RUB',precision:0});
            }


        }
    }
</script>
