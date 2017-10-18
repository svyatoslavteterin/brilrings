<template>
    <div class="blocks">

          <div class="blocks__item"  v-for="(value,index)  in blocks" :id="value">

              <div v-if="value==='result-img'">
                <img :src="resultImg" />
              </div>

          </div>


    </div>

</template>

<script>
    module.exports = {
    methods: {

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
            return '/resultimage/'+this.getHash;
          },
          getHash:function(){
            return '12421412.jpg';
          }
        }
    }
</script>
