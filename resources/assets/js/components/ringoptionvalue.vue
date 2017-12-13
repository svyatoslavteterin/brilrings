<template>


            <li v-if="optionTemplate=='imageslider'" :class="{ active: isActive }"><a href="#" @click.prevent="chooseOption">

              <img :src="'/baseimages/'+ringOptionValue.value+'/'+storeValue('material','value')+'/small/'+storeValue('shape','value')" width="140" height="70" :title="ringOptionValue.title"/>
            </a></li>

            <li v-else-if="optionTemplate=='imagebox'" :class="{ active: isActive,disable:isDisabled}"><a href="#" :class="optionKey+''+ringOptionValue.value" @click.prevent="chooseOption">{{ringOptionValue.title}}</a></li>

            <option v-else-if="optionTemplate==='selectbox'" :value="ringOptionValue.value"  :class="{ active: isActive,disable:isDisabled }" >{{ringOptionValue.title}}</option>
            <input v-else-if="optionTemplate==='text'" value="text">
            <div v-else-if="optionTemplate=='card'" class="col-xs-6  col-sm-4 col-md-4 col-xl-4 card__item" @click="gotoConstructor('/constructor/base/'+ringOptionValue.value+'/'+storeValue('material','value'))">
                <div class="card__item__wrapper">
                  <div class="card__img"><img :src="/baseimages/+ringOptionValue.value+'/'+storeValue('material','value')+'/medium'" :alt="ringOptionValue.title" /></div>
                  <div class="card__title">{{ringOptionValue.title}}</div>
                  <div class="card__material" v-text="storeValue('material','title')"></div>
                  <div class="card__price" v-text="formatPrice(ringOptionValue.price.material[storeValue('material','value')])"></div>
                  <a class="btn btn-primary" :href="'/constructor/base/'+ringOptionValue.value+'/'+storeValue('material','value')">Выбрать</a>
                </div>
             </div>
            <div v-else-if="optionTemplate==='switch'">{{ringOptionValue.title}}</div>



</template>


<script>
    module.exports = {
    methods: {
      formatPrice:function(price){
        return currencyFormatter.format(price, { code: 'RUB',precision:0});

      },
      gotoConstructor:function(link){
        window.location.href=link;
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

        props:['ringOptionValue','optionTemplateValue','optionCount','optionKey','ringOptionValues'],

        ready: function () {



        },
        mounted:function(){


          if ($(window).width() <= 990)  {

                $('.jcarousel').jcarousel();
          }else{
            $('.jcarousel').jcarousel({
                vertical: true
            });
          }




          $('.jcarousel').jcarouselSwipe({
              perSwipe: 2 // by default 1
          });
        },



        computed: {

          isActive:function(){
            if (this.value===store.state.session[this.optionKey]){
              return true;
            }
          },
          isDisabled:function(){
            if (this.optionKey=="shape"){
              if (store.state.enabledShapes.indexOf(this.value)==-1) {
                return true;
              }
            }
          },
          isSelected:function(){
            if (this.value===store.state.session[this.optionKey]){
              return 'selected';
            }
          },
          imgHash:function(){

          }




        }
    }
</script>
