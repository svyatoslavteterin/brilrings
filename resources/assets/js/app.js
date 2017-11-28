
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');



window.jcarousel = require('jcarousel');
window.jcarouselSwipe = require('jcarouselSwipe');





var md5 = require('md5');

window.currencyFormatter = require('currency-formatter');

window.fx = require("money");


window.Vue = require('vue');

window.Vuex=require('vuex');

Vue.use(Vuex);



Vue.prototype.$http = axios;

import { mapState } from 'vuex';







/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 Vue.component('ringoptions',require('./components/ringoptions.vue'));
 Vue.component('ringblocks',require('./components/ringblocks.vue'));

 Vue.component('ringoption',require('./components/ringoption.vue'));

 Vue.component('ringoptionvalue',require('./components/ringoptionvalue.vue'));

Vue.component('steps',require('./components/steps.vue'));

fx.rates['RUB']=60;

$.getJSON(
    	// NB: using Open Exchange Rates here, but you can use any source!
        'https://openexchangerates.org/api/latest.json?app_id=cc24b33091c34b19a0f4dea626cab8a2',
        function(data) {
            // Check money.js has finished loading:
            if ( typeof fx !== "undefined" && fx.rates ) {
                fx.rates = data.rates;
                fx.base = data.base;
            } else {
                // If not, apply to fxSetup global:
                var fxSetup = {
                    rates : data.rates,
                    base : data.base
                }
            }
        }
    );


window.store = new Vuex.Store({
  state: {
    value:0,
    basePrice:0,
    stonePrice:0,
    totalPrice: 22000,
    session: {},
    resultImg:'',
    step:activeStep,
    enabledShapes:[1,2,3,4,5,6,7,8]

  },
  mutations: {
    init(state,payload){
      state.session=payload;
    },
    setOption (state,payload) {
      state.session[payload.optionKey]=parseInt(payload.value);

      if (payload.optionKey=="size"){
          for (var weight  in RingApp.weight_size_map.aliases) {
              if (RingApp.weight_size_map.aliases[weight]==parseInt(payload.value)){
                state.session['weight']=weight;
                  RingApp.$refs.steps.$refs.ringoptions[0].$refs.ringoption[1].value=weight;
              }
          }



      }
      if (payload.optionKey=="weight"){

        state.session.size=parseInt(RingApp.weight_size_map.aliases[parseInt(payload.value)]);

          // hook to set value to weight

        RingApp.$refs.steps.$refs.ringoptions[0].$refs.ringoption[2].value=parseInt(payload.value);

      }


        var excludeParams=RingApp.$data.excludeParams;

      //Refresh image after change option but watch exclude params

      if (excludeParams.indexOf(payload.optionKey)==-1)  store.dispatch('refreshResultImg');

      //Refresh base and stone prices after change options

      store.dispatch('refreshPrices');


    },


    setImage(state,payload){
      state.resultImg=payload.value;
    }
  },
  getters: {

  },
  actions:{
    refreshResultImg(context){
      var str='';


      var excludeParams=RingApp.$data.excludeParams;

      var params=context.state.session;

      for (var prop in params) {

        if (excludeParams.indexOf(prop)>-1) {

           str+=prop+1;
        }else{
         str+=prop+params[prop];
       }
      }

      RingApp.$http.get('/resultimage/'+params['base']+'/'+params['material']+'/'+params['shape']+'/'+params['weight']+'/'+md5(str)).then((response)=>{




          context.state.enabledShapes=Object.values(response.data.shapes);

          if (response.data.shapes.indexOf(context.state.session.shape)==-1) {
            context.state.session.shape=1;
          }
            context.state.resultImg=response.data.image;

      },(response)=> {

      });

    },
    refreshPrices(context){
      var basePrice=parseInt(RingApp.$data.ringOptionValues.base[context.state.session.base].price.material[context.state.session.material]);
      context.state.basePrice=basePrice;
        RingApp.$http.get('/getprice/'+context.state.session.shape+'/'+context.state.session.weight+'/'+context.state.session.color+'/'+context.state.session.purity).then((response)=>{
            var stonePrice=Math.round(fx.rates['RUB']*response.data.price);
            context.state.stonePrice=stonePrice;
            context.state.totalPrice=basePrice+stonePrice;
          });


    }
  }

})


window.RingApp = new Vue({
    el: '#app',
    data:{
        'excludeParams':['fsize','purity','stone','color','size'],
        'ringOptions':{},
        'ringOptionValues':{},
        'weight_size_map':{},
        'steps':steps
    },
    methods: {
      getHash:function(){

      },
      isActive(step){
        if (store.state.step==step){
          return true;
        }
      },
      nextStep(step){
        store.state.step=step;
      }
    },
    created:function(){






        this.$http.get('/ring_options').then((response)=>{
        this.ringOptions=response.data;
        var session={};
        var str='';


        _.forOwn(this.ringOptions, function(value, key) {
          if (parseInt(value.desc)) {
            session[key]=parseInt(value.desc);
          }else{
              session[key]=1;
          }

        });

        if (typeof(ringBase)!="undefined") session['base']=parseInt(ringBase);
        if (typeof(ringMaterial)!="undefined") session['material']=parseInt(ringMaterial);


        var excludeParams=this.excludeParams;
          _.forOwn(this.ringOptions, function(value, key) {

            if (excludeParams.indexOf(key)==-1)  {
              str+=key+session[key];
            }else{
                str+=key+1;
            }
        });

        this.$http.get('/resultimage/'+session['base']+'/'+session['material']+'/1/8/'+md5(str)).then((response)=>{


            store.state.resultImg=response.data.image;

            store.state.enabledShapes=Object.values(response.data.shapes);

        },(response)=> {

        });






        store.commit('init',session);


      },(response)=> {

      });
      this.$http.get('/ring_option_values').then((response)=>{

        this.ringOptionValues=response.data;

        store.state.basePrice=parseInt(this.$data.ringOptionValues.base[store.state.session.base].price.material[store.state.session.material]);

        this.$http.get('/getprice/'+store.state.session.shape+'/'+store.state.session.weight+'/'+store.state.session.color+'/'+store.state.session.purity).then((response)=>{

              store.state.stonePrice=Math.round(fx.rates['RUB']*response.data.price);
              store.state.totalPrice=store.state.basePrice+store.state.stonePrice;
          });

      },(response)=> {

      });

      this.$http.get('/weight_size_map').then((response)=>{
        this.weight_size_map=response.data;
      },(response)=>{

      });
    },
    computed:{
      getTotalPrice:function(){
        return store.state.totalPrice;
      },
      getBasePrice:function(){

      }
    },
    mounted:function(){





    }
});
