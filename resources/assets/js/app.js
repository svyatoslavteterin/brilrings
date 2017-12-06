
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

if (typeof activeStep=="undefined") {
  window.activeStep=0;
}

if (typeof steps=="undefined") {
  window.steps={};
}

window.jcarousel = require('jcarousel');
window.jcarouselSwipe = require('jcarouselSwipe');


var $ = require('jquery');
require('fancybox')($);

$(document).ready(function() {
     $('.fancybox').fancybox();
});

window.md5 = require('md5');

window.currencyFormatter = require('currency-formatter');

window.fx = require("money");


window.Vue = require('vue');

import VModal from 'vue-js-modal'


window.Vuex=require('vuex');

Vue.use(Vuex);
Vue.use(VModal);

Vue.component('steps',require('./components/steps.vue'));
Vue.component('ringoptions',require('./components/ringoptions.vue'));
Vue.component('ringoption',require('./components/ringoption.vue'));
Vue.component('ringoptionvalue',require('./components/ringoptionvalue.vue'));
Vue.component('ringblocks',require('./components/ringblocks.vue'));


Vue.prototype.$http = axios;

import { mapState } from 'vuex';







/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



fx.rates['RUB']=60;

/* Don't use, we set rate ourself
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

*/


window.store = new Vuex.Store({
  state: {
    value:0,
    basePrice:0,
    stonePrice:{},
    totalPrice: 22000,
    session: {},
    resultImg:{},
    activeResultImg:0,
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
                state.session['weight']=parseInt(weight);
                  RingApp.$refs.steps.$refs.ringoptions[0].$refs.ringoption[1].value=weight;
              }
          }



      }
      if (payload.optionKey=="weight"){

        state.session.size=parseInt(RingApp.weight_size_map.aliases[parseInt(payload.value)]);

          // hook to set value to weight

        RingApp.$refs.steps.$refs.ringoptions[0].$refs.ringoption[2].value=parseInt(payload.value);

      }

      //history


      var newUrl=baseurl+state.session.base+'/'+state.session.material+'/'+state.session.shape+'/'+state.session.weight+'/'+state.session.color+'/'+state.session.stone+'/';



      window.history.pushState('constructor', 'Ring Constructor', newUrl);

        var excludeParams=RingApp.$data.excludeParams;

      //Refresh image after change option but watch exclude params

      if (excludeParams.indexOf(payload.optionKey)==-1)  store.dispatch('refreshResultImg');

      //Refresh base and stone prices after change options

      store.dispatch('refreshPrices');


    },


    setImage(state,payload){
      state.activeResultImg=payload.value;
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

      RingApp.$http.get('/resultimage/'+params['base']+'/'+params['material']+'/'+params['shape']+'/'+params['weight']).then((response)=>{




          context.state.enabledShapes=Object.values(response.data.shapes);

          if (response.data.shapes.indexOf(context.state.session.shape)==-1) {
              store.commit('setOption',{'value':1,'optionKey':'shape'});
          }
            context.state.resultImg=response.data.image;


      },(response)=> {

      });

    },
    refreshPrices(context){
      var basePrice=parseInt(RingApp.$data.ringOptionValues.base[context.state.session.base-1].price.material[context.state.session.material]);
      context.state.basePrice=basePrice;
        RingApp.$http.get('/getprice/'+context.state.session.shape+'/'+context.state.session.weight+'/'+context.state.session.color+'/'+context.state.session.purity).then((response)=>{
            var stonePrice={
              '1':Math.round(fx.rates['RUB']*response.data.price),
              '2':Math.round(fx.rates['RUB']*response.data.mussanit_price)
            };
            context.state.stonePrice=stonePrice;
            store.state.totalPrice=store.state.basePrice+store.state.stonePrice[store.state.session.stone];
          });


    }
  }

})


window.RingApp = new Vue({
    el: '#app',
    components:'',

    data:{
        'excludeParams':['fsize','purity','stone','color'],
        'ringOptions':{},
        'ringOptionValues':{},
        'weight_size_map':{},
        'steps':steps
    },
    methods: {

      callOrder:function(){
        var formData = $("#call-order-form").serializeArray();

          let options = { emulateJSON: true };

                  this.$http.post('/call-order',{store:store.state,data:formData},options).then(function (response) {

                      // Success
                      console.log(response.data)
                  },function (response) {
                      // Error
                      console.log(response.data)
                  });
      },
      helpOrder:function(step){
        var formData = $("#help-order"+step+"-form").serializeArray();

          let options = { emulateJSON: true };

                  this.$http.post('/help-order',{store:store.state,data:formData},options).then(function (response) {

                      // Success
                      console.log(response.data)
                  },function (response) {
                      // Error
                      console.log(response.data)
                  });
      },
      guestOrder:function(){
        var formData = $("#guest-order-form").serializeArray();

          let options = { emulateJSON: true };

                  this.$http.post('/guest-order',{store:store.state,data:formData},options).then(function (response) {

                      // Success
                      console.log(response.data)
                  },function (response) {
                      // Error
                      console.log(response.data)
                  });
      },
      ringOrder:function(){
        var formData = $("#ring-order-form").serializeArray();

          let options = { emulateJSON: true };

                  this.$http.post('/ring_sessions',{store:store.state,data:formData},options).then(function (response) {

                      // Success
                      console.log(response.data)
                  },function (response) {
                      // Error
                      console.log(response.data)
                  });
      },
      saveToEmail:function(){


        var formData = JSON.stringify($("#savetoemail-form").serializeArray());

        let options = { emulateJSON: true };

        this.$http.post('/savetoemail',{store:store.state,data:formData},options).then(function (response) {

            // Success
            console.log(response.data)
        },function (response) {
            // Error
            console.log(response.data)
        });
      },
      getHash:function(){

      },
      isActive(step){
        if (store.state.step==step){
          return true;
        }
      },
      nextStep(step){
        store.commit('setImage',{value:0});
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
              session[key]=0;
          }

        });
            store.commit('init',session);

        if (typeof(ringBase)!="undefined") session['base']=parseInt(ringBase);
        if (typeof(ringMaterial)!="undefined") session['material']=parseInt(ringMaterial);
        if (typeof(ringShape)!="undefined") session['shape']=parseInt(ringShape);
        if (typeof(ringWeight)!="undefined") session['weight']=parseInt(ringWeight);
        if (typeof(ringColor)!="undefined") session['color']=parseInt(ringColor);
        if (typeof(ringStone)!="undefined") session['stone']=parseInt(ringStone);


        var excludeParams=this.excludeParams;
          _.forOwn(this.ringOptions, function(value, key) {

            if (excludeParams.indexOf(key)==-1)  {
              str+=key+session[key];
            }else{
                str+=key+1;
            }
        });

        this.$http.get('/resultimage/'+session['base']+'/'+session['material']+'/'+session['shape']+'/'+session['weight']).then((response)=>{


            store.state.resultImg=response.data.image;


            store.state.enabledShapes=Object.values(response.data.shapes);

        },(response)=> {

        });






        store.commit('init',session);


      },(response)=> {

      });
      this.$http.get('/ring_option_values').then((response)=>{

        this.ringOptionValues=response.data;

        store.state.basePrice=parseInt(this.$data.ringOptionValues.base[store.state.session.base-1].price.material[store.state.session.material]);

        this.$http.get('/getprice/'+store.state.session.shape+'/'+store.state.session.weight+'/'+store.state.session.color+'/'+store.state.session.purity).then((response)=>{

              var stonePrice={
                '1':Math.round(fx.rates['RUB']*response.data.price),
                '2':Math.round(fx.rates['RUB']*response.data.mussanit_price)
              };
              store.state.stonePrice=stonePrice;

              store.state.totalPrice=store.state.basePrice+store.state.stonePrice[store.state.session.stone];

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




$('.order-call-btn').click(function(e){
  e.preventDefault();
  RingApp.$modal.show('call-order');
});

$('.btn-register').click(function(e){
  e.preventDefault();
  RingApp.$modal.show('guest-order');
});
