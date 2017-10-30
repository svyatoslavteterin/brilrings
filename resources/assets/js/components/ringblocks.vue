<template>
    <div class="blocks">

          <div class="blocks__item"  v-for="(value,index)  in blocks" :id="value">

              <div v-if="value==='result-img'">
                <img :src="resultImg" />

              </div>

              <div v-if="value==='info'" class="ring-info">
                <h3 v-text="storeValue('base','title')"> </h3>
                <div class="ring-info__desc" v-text="storeValue('base','desc')"> </div>
              </div>


              <div v-else-if="value==='result-table'">
                  <h3>Бриллиант</h3>
                  <p><span v-text="totalPrice"></span> <span class="currency">руб</span></p>
                  <table>
                    <tr>
                      <td>Форма огранки</td>
                      <td v-text="storeValue('shape','title')"></td>
                    </tr>
                    <tr>
                      <td>Вес камня</td>
                      <td v-text="storeValue('weight','title')"></td>
                    </tr>
                    <tr>
                      <td>Цвет</td>
                      <td v-text="storeValue('color','title')"></td>
                    </tr>
                    <tr>
                      <td>Чистота</td>
                      <td v-text="storeValue('purity','title')"></td>
                    </tr>
                    <tr>
                      <td>Размер</td>
                      <td v-text="storeValue('size','title')"></td>
                    </tr>

                  </table>
                  <p>Итоговая цена:</p>
                  <p><span v-text="totalPrice"></span> <span class="currency">руб</span></p>
              </div>

          </div>


    </div>

</template>

<script>
    module.exports = {
    methods: {
      test:function(){
          store.commit('setImage',{'value':'12.jpg'});

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
          resultImg:function(){
            return store.state.resultImg;
          },
          totalPrice:function(){
            return store.state.totalPrice;
          },
          getOptionValue:function(){


          },

        }
    }
</script>
