
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');



window.Vue = require('vue');

window.Vuex=require('vuex');




Vue.prototype.$http = axios;



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 Vue.component('ringoptions',require('./components/ringoptions.vue'));
 Vue.component('ringoption',require('./components/ringoption.vue'));

 Vue.component('ringoptionvalue',require('./components/ringoptionvalue.vue'));

Steps=Vue.component('steps',require('./components/steps.vue'));





RingApp = new Vue({
    el: '#app',
    data:{
      'session': {
        	'base': {
        		'model':1,
        		'material':1
          },

        'stone': {
        		'shape':1,
        		'size':1,
        		'weight':1,
        		'purity':1,
        		'color':1
        	}

        },
        'totalprice':0,
        'ringOptions':{},
        'ringOptionValues':{},
        'steps':[{
          'left':{
            'options':['model'],
          },
          'center': {
            'blocks':['result-img']
          },
          'right':{
            'options':['material','stone'],
            'blocks':['thumb-img']
          },
          'template':'base'
        },
        {
          'left':{
            'options':['stone','shape','weight','size','color','purity']
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
            'options':['fsize']
          },
          'template':'result'
        }

        ]

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
