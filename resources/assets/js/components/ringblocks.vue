<template>
    <div class="blocks">

          <div class="blocks__item"  v-for="(value,index)  in blocks" :id="value" :class="value">

              <div v-if="value==='result-img'">
                <img :src="resultImg" class="img-fluid" :class="'img'+storeParam('activeResultImg')" />

              </div>

              <div v-if="value==='info'" class="ring-info">
                <h3 v-text="storeValue('base','title')"> </h3>
                <div class="ring-info__desc" v-text="storeValue('base','desc')"> </div>
              </div>
              <div v-if="value==='stone-info'" class="stone-info">
                <h3 class="totalprice__title" v-text="storeValue('stone','title')"> </h3>
                  <p class="price"><span v-text="getStonePrice"></span> </p>
              </div>

                <div v-else-if="value==='ring-images'" class="ring-image">
                  <ul>
                    <li :class="{ active: isActive(0) }"> <a href="#" @click.prevent="updateResultImg(0)"><img :src="getImage(0)" alt="" width="150" height="150"/></a> </li>
                    <li :class="{ active: isActive(1) }"> <a href="#" @click.prevent="updateResultImg(1)"><img :src="getImage(1)" alt="" width="150" height="150"/></a> </li>
                  </ul>

                </div>
              <div v-else-if="value==='result-table'">

                  <table>
                    <tr>
                      <th>Форма огранки</th>
                      <td v-text="storeValue('shape','title')"></td>
                    </tr>
                    <tr>
                      <th>Вес камня</th>
                      <td v-text="storeValue('weight','title')"></td>
                    </tr>
                    <tr>
                      <th>Качество</th>
                      <td v-text="storeValue('color','title')"></td>
                    </tr>

                    <tr>
                      <th>Диаметр</th>
                      <td v-text="storeValue('size','title')"></td>
                    </tr>

                  </table>

              </div>

          </div>


    </div>

</template>

<script>
    module.exports = {
    methods: {
      updateResultImg:function(index){
        store.commit('setImage',{'value':index});
      },
      isActive:function(index){
        if (index==store.state.activeResultImg){
          return true;
        }
      },
      test:function(){
          store.commit('setImage',{'value':'12.jpg'});

      },
      storeParam:function(param){
        return store.state[param];
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

      getImage:function(index=0){
                return store.state.resultImg[index];
      }

      },

      data() {


        return {
          field: ''
        }
        },

        props:['blocks','ringOptionValues'],

        ready: function () {



        },
        mounted:function(){

        },



        computed: {
          resultImg:function(i){
            return store.state.resultImg[store.state.activeResultImg];

          },

          totalPrice:function(){
            return currencyFormatter.format(store.state.totalPrice, { code: 'RUB',precision:0});
          },
          getStonePrice:function(){
            console.log(store.state.stonePrice);
            return currencyFormatter.format(store.state.stonePrice, { code: 'RUB',precision:0});
          },
          getOptionValue:function(){


          },

        }
    }
</script>
