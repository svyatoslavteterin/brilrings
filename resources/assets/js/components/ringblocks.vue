<template>
    <div class="blocks">

          <div class="blocks__item"  v-for="(value,index)  in blocks" :id="value">

              <div v-if="value==='result-img'">
                <img :src="resultImg" />

              </div>


              <div v-else-if="value==='result-table'">

                  <table>
                    <tr>
                      <td>Форма огранки</td>
                      <td v-text="storeValue('shape')"></td>
                    </tr>
                    <tr>
                      <td>Вес камня</td>
                      <td v-text="storeValue('weight')"></td>
                    </tr>
                    <tr>
                      <td>Цвет</td>
                      <td v-text="storeValue('color')"></td>
                    </tr>
                    <tr>
                      <td>Чистота</td>
                      <td v-text="storeValue('purity')"></td>
                    </tr>
                    <tr>
                      <td>Размер</td>
                      <td v-text="storeValue('size')"></td>
                    </tr>

                  </table>

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
      storeValue:function(optionKey){
        var optionvalue=store.state.session[optionKey];

        var ringOptionValues=RingApp.$data.ringOptionValues;

        var title='';
        for (var i=0;i<ringOptionValues[optionKey].length;i++){
          if (ringOptionValues[optionKey][i].value==optionvalue){
            title=ringOptionValues[optionKey][i].title;
            break;
          }
        }
        return title;
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
