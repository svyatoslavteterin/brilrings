<template>
    <div class="steps">
        <div v-for="step in stepsList" class="steps__item">
              <div v-if="step.template==='base'" class="container">
                  <div class="row">
                    <div class="col-md-1 left-col">
                        <ringoptions :options="step.left.options"></ringoptions>
                    </div>
                    <div class="col-md-6 center-col" @click="update">center </div>
                    <div class="col-md-5 center-col"> right</div>
                  </div>
              </div>
              <div v-if="step.template==='stone'" class="container">
                <div class="col-md-3 left-col">
                  left
                </div>
                <div class="col-md-4 center-col">
                    center
                </div>
                <div class="col-md-5 ">
                    right
                </div>
              </div>
              <div v-if="step.template==='result'" class="container">
                  <div class="col-md-8 center-col">
                    center
                  </div>
                  <div class="col-md-4 right-col">
                      right
                  </div>

              </div>
        </div>

    </div>

</template>

<script>
    module.exports = {
    methods: {
        update:function(){
                this.ringOptions={'fdsf':2};

        }
      },

        data:function(){
            return  {
              ringChildOptions:this.ringOptions
            };
          },

        props:['stepsList','ringOptions'],

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
