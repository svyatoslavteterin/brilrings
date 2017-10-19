<template>
    <div class="steps">
        <div v-for="(step,key,index) in stepsList" class="steps__item" >

        {{index}}
              <div v-if="step.template==='base'" class="container" >
                  <div class="row">
                    <div class="col-md-2 left-col">
                        <ringoptions :options="step.left.options" :ring-options="SRingOptions" :ring-option-values="SRingOptionValues"></ringoptions>

                    </div>
                    <div class="col-md-8 center-col" >
                      <ringblocks :blocks="step.center.blocks" ref="blocks"></ringblocks>
                    </div>
                    <div class="col-md-2 center-col">
                        <ringoptions :options="step.right.options" :ring-options="SRingOptions" :ring-option-values="SRingOptionValues"></ringoptions>
                        <p v-model="getTotalPrice" v-text="getTotalPrice" > </p>
                    </div>
                  </div>
              </div>
              <div v-if="step.template==='stone'" class="container">
                <div class="row">
                  <div class="col-md-4 left-col">
                      <ringoptions :options="step.left.options" :ring-options="SRingOptions" :ring-option-values="SRingOptionValues"></ringoptions>
                  </div>
                  <div class="col-md-5 center-col">
                        <ringblocks :blocks="step.center.blocks" ref="blocks"></ringblocks>
                  </div>
                  <div class="col-md-3 ">
                        <ringblocks :blocks="step.right.blocks" ref="blocks" :ring-option-values="SRingOptionValues"></ringblocks>
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
              'active':1

            };
          },

        props:['stepsList','SRingOptions','SRingOptionValues'],

        ready: function () {


        },
        mounted:function(){


        },



        computed: {
          getTotalPrice:function(){
            return store.state.totalPrice;
          },
          isActive:function(){
            if (this.active===store.state.step){
              return true;
            }
          }
        }
    }
</script>
