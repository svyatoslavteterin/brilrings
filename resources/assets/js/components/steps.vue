<template>
    <div class="steps">
        <div v-for="step in stepsList" class="steps__item">
              <div v-if="step.template==='base'" class="container">
                  <div class="row">
                    <div class="col-md-1 left-col">
                        <ringoptions :options="step.left.options" :ring-options="ringOptions" :ring-option-values="ringOptionValues"></ringoptions>
                    </div>
                    <div class="col-md-6 center-col" @click="update">center </div>
                    <div class="col-md-5 center-col">
                        <ringoptions :options="step.right.options" :ring-options="ringOptions" :ring-option-values="ringOptionValues"></ringoptions>
                    </div>
                  </div>
              </div>
              <div v-if="step.template==='stone'" class="container">
                <div class="row">
                  <div class="col-md-3 left-col">
                      <ringoptions :options="step.left.options" :ring-options="ringOptions" :ring-option-values="ringOptionValues"></ringoptions>
                  </div>
                  <div class="col-md-4 center-col">
                      center
                  </div>
                  <div class="col-md-5 ">
                        <ringoptions :options="step.right.options" :ring-options="ringOptions" :ring-option-values="ringOptionValues"></ringoptions>
                  </div>
                </div>
              </div>
              <div v-if="step.template==='result'" class="container">
                  <div class="col-md-8 center-col">
                    center
                  </div>
                  <div class="col-md-4 right-col">
                        <ringoptions :options="step.right.options" :ring-options="ringOptions" :ring-option-values="ringOptionValues"></ringoptions>
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
              ringOptions:this.ringOptions
              
            };
          },

        props:['stepsList','ringOptions','ringOptionValues'],

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
