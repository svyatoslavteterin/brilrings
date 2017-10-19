<template>
    <div class="blocks">

          <div class="blocks__item"  v-for="(value,index)  in blocks" :id="value">

              <div v-if="value==='result-img'">
                <img :src="resultImg" />
                <button @click.prevent="test">CHANGE IMAGE</button>
              </div>

          </div>


    </div>

</template>

<script>
    module.exports = {
    methods: {
      test:function(){
          store.commit('setImage',{'value':'12.jpg'});

      }
      },

      data() {


        return {
          field: ''
        }
        },

        props:['blocks'],

        ready: function () {



        },
        mounted:function(){

        },



        computed: {
          resultImg:function(){
            return store.state.resultImg;
          }
        }
    }
</script>
