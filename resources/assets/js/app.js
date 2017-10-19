
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');





window.Vue = require('vue');

window.Vuex=require('vuex');

Vue.use(Vuex);




Vue.prototype.$http = axios;

import { mapState } from 'vuex';

window.store = new Vuex.Store({
  state: {
    value:0,
    totalPrice: 0,
    session: {
        'base':1,
         'stone':1,
         'material':1,
         'shape':1,
         'size':1,
         'weight':1,
         'purity':1,
         'color':1,
         'fsize':1
        },
      resultImg:'/resultimage/'+'12421412.jpg'

  },
  mutations: {
    setOption (state,payload) {
      state.session[payload.optionKey]=parseInt(payload.value);

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

  }
})



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





window.RingApp = new Vue({
    el: '#app',
    data:{
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
        return '12421412';
      }
    },
    created:function(){
      this.$http.get('/ring_options').then((response)=>{
        this.ringOptions=response.data;

      /*  var steps=[];


        for (var key in this.ringOptions){

          steps.push({'key':key,'options':this.ringOptions[key]});

        }


        steps.push({'key':'result','options':this});

        this.steps=steps;
        */
      },(response)=> {

      });
      this.$http.get('/ring_option_values').then((response)=>{

        this.ringOptionValues=response.data;
      },(response)=> {

      });
    },
    computed:{

    },
    mounted:function(){





    }
});
