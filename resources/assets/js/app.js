
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

var md5 = require('md5');



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


window.store = new Vuex.Store({
  state: {
    value:0,
    totalPrice: 0,
    session: {},
    resultImg:'',
    step:1

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
        'steps':[
          {
          'left':{
            'options':[
              {
                'base':'imageslider'
              }
            ],
          },
          'center': {
            'blocks':['result-img']
          },
          'right':{
            'options':[
              {
                'material':'selectbox'
              },
              {
                'stone':'selectbox'
              }
            ],
            'blocks':['thumb-img']
          },
          'template':'base'
        },
        {
          'left':{
            'options':[
              {
                'shape':'imagebox'
              },
              {
                'weight':'range'
              },
              {
                'size':'range'
              },
              {
                'color':'range'
              },
              {
                'purity':'range'
              }
            ]
          },
          'center':{
            'blocks':['result-img']
          },
          'right':{
            'blocks':['result-table']
          },
          'template':'stone'

        },
        {
          'center':{
            'blocks':['result-img','thumb-img']
          },
          'right':{
            'blocks':['result-table'],
            'options':[{'fsize':'range'}]
          },
          'template':'result'
        }

        ]

    },
    methods: {
      getHash:function(){

      }
    },
    created:function(){
        this.$http.get('/ring_options').then((response)=>{
        this.ringOptions=response.data;
        var session={};
        var str='';


        _.forOwn(this.ringOptions, function(value, key) {
          session[key]=1;
          str+=key+1;
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
