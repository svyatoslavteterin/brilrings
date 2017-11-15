
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




window.Vue = require('vue');

window.Vuex=require('vuex');

Vue.use(Vuex);



Vue.prototype.$http = axios;

import { mapState } from 'vuex';


const currencyConvert = require('currency-convert');




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


window.store = new Vuex.Store({
  state: {
    value:0,
    totalPrice: 22000,
    session: {},
    resultImg:'',
    step:activeStep

  },
  mutations: {
    init(state,payload){
      state.session=payload;
    },
    setOption (state,payload) {
      state.session[payload.optionKey]=parseInt(payload.value);

        var excludeParams=RingApp.$data.excludeParams;

      //Refresh image after change option but watch exclude params

      if (excludeParams.indexOf(payload.optionKey)==-1)  store.dispatch('refreshResultImg');


    },
    refreshResultImg(state){

      state.resultImg='/resultimage/'+this.getHash;

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

          params[prop]=1;
        }
         str+=prop+params[prop];
      }

      context.state.resultImg='/resultimage/'+md5(str);


    }
  }
})


window.RingApp = new Vue({
    el: '#app',
    data:{
        'excludeParams':['fsize','purity','stone','color'],
        'ringOptions':{},
        'ringOptionValues':{},
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

  


        this.$http.get('/getprice').then((response)=>{
          currencyConvert(response.data, 'USD', 'RUB').then(console.log).catch(console.log);
        });

        this.$http.get('/ring_options').then((response)=>{
        this.ringOptions=response.data;
        var session={};
        var str='';


        _.forOwn(this.ringOptions, function(value, key) {
          session[key]=1;

        });

        if (typeof(ringBase)!="undefined") session['base']=parseInt(ringBase);
        if (typeof(ringMaterial)!="undefined") session['material']=parseInt(ringMaterial);



          _.forOwn(this.ringOptions, function(value, key) {
              str+=key+session[key];
        });

        store.state.resultImg='/resultimage/'+md5(str);
        store.commit('init',session);


      },(response)=> {

      });
      this.$http.get('/ring_option_values').then((response)=>{

        this.ringOptionValues=response.data;
      },(response)=> {

      });
    },
    computed:{
      getTotalPrice:function(){
        return store.state.totalPrice;
      }
    },
    mounted:function(){





    }
});
