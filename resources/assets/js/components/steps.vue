<template>
    <div class="steps">
        <div v-for="step in stepsList" class="steps__item">
              <div v-if="step.template==='start'" class="container">
                  <ringoptions :options="step.center.options" :ring-options="SRingOptions" :ring-option-values="SRingOptionValues"></ringoptions>


              </div>
              <div v-if="step.template==='base'" class="container">
                  <div class="row">
                    <div class="col-md-2 left-col">
                        <ringoptions :options="step.left.options" :ring-options="SRingOptions" :ring-option-values="SRingOptionValues"></ringoptions>

                    </div>
                    <div class="col-md-5 center-col" >
                      <ringblocks :blocks="step.center.blocks" ref="blocks"></ringblocks>
                    </div>
                    <div class="col-md-5 center-col">
                        <ringoptions :options="step.right.options" :ring-options="SRingOptions" :ring-option-values="SRingOptionValues"></ringoptions>
                        <p v-model="price" v-text="price"> </p>
                    </div>
                  </div>
              </div>
              <div v-if="step.template==='stone'" class="container">
                <div class="row">
                  <div class="col-md-4 left-col">
                      <ringoptions :options="step.left.options" :ring-options="SRingOptions" :ring-option-values="SRingOptionValues"></ringoptions>
                  </div>
                  <div class="col-md-3 center-col">
                      center
                  </div>
                  <div class="col-md-5 ">

                  </div>
                </div>
              </div>
              <div v-if="step.template==='result'" class="container">
                  <div class="col-md-8 center-col">
                    center
                  </div>
                  <div class="col-md-4 right-col">
                        <ringoptions :options="step.right.options" :ring-options="SRingOptions" :ring-option-values="SRingOptionValues"></ringoptions>
                  </div>

              </div>
        </div>

    </div>

</template>

<script>
    module.exports = {
    methods: {
        update:function(){


        }
      },

        data:function(){
            return  {

              'price':12400
            };
          },

        props:['stepsList','SRingOptions','SRingOptionValues'],

        ready: function () {


        },
        mounted:function(){


        },



        computed: {
          test:function(){
            return "<ringoptions></ringoptions>";
          }
        }
    }
</script>
