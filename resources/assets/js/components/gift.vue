<template>

  <div class="gifts__item">
  <div class="col-md-4">
    <a class="for-her__item" @click="selectGift">
        <img class="img-fluid" :src="getImage(0)" alt="for-her"/>
    </a>
  </div>

  <modal :name="modalName" height="auto" adaptive v-cloak width="80%"  >
    <button @click="$modal.hide(modalName)" class="modal-close">
        <img src="images/close.png" alt="close"/>
    </button>

    <div class="modal-body">
      <div class="row">
        <div class="col-lg-6 col-md-6">
          <img :src="resultImg" alt="gift" class="img-fluid" />
        </div>
        <div class="col-lg-6 col-md-6">
        <div class="ring-images">
          <ul>
            <li v-for="(image,index) in data.images" :class="{ active: isActive(index) }"> <a href="#" @click.prevent="updateResultImg(index)"><img :src="getImage(index)" alt="" width="150" height="150"/></a> </li>
          </ul>
        </div>
        <div class="ring-info">
          <h3 v-text="data.title"></h3>
          <div class="ring-info__desc" v-text="data.desc"></div>
        </div>

        <ringoption
        :option="value"
        v-for="(value,key,index)  in this.options"
        :ring-options="giftOptions"
        :ring-option-values="giftOptionValues"
        :store="false"
        :params="store"
        :option-key="value"
        :key="index"
        ref="ringoption"
        v-on:update="update"
        >
        </ringoption>

            <p ><span v-text="totalPrice" class="price"> </span></p>

            <div class="action-btns">
              <button class="btn btn-primary btn-order" @click.prevent="order()">Заказать</button>
              <button class="btn btn-default btn-help" @click="$modal.show('help-order3')">Помощь специалиста</button>
            </div>


        </div>
      </div>
    </div>
  </modal>
  </div>
</template>

<script>
    module.exports = {
    methods: {
      update:function(param){
        for (var prop in param) {
          this.$nextTick(function () {
            this.store[prop]=param[prop];
          });
        }
      },
      selectGift:function(){
          RingApp.$data.activeGift=this.data.id;
          RingApp.$modal.show(this.modalName);
      },
      save:function(){

          RingApp.$modal.hide(modalName);
          RingApp.$modal.show('save-to-email');
      },
      order:function(){
        let store={};
        store.material=RingApp.$refs.gift[RingApp.$data.activeGift-1].$refs.giftoptions.$children[0].$data.value;
        store['gift'+RingApp.$data.activeGift]=RingApp.$refs.gift[RingApp.$data.activeGift-1].$refs.giftoptions.$children[1].$data.value;

        this.store=store;
          RingApp.$modal.hide(this.modalName);
          RingApp.$modal.show('gift-order');
      },
      updateResultImg:function(index){

        this.$nextTick(function () {
            this.activeImg=index;
         });

      },
      isActive:function(index){
        if (index==this.activeImg){
          return true;
        }
      },
      getImage:function(index=0){
                return this.data.images[index];
      }

      },
      created() {

      },
      data() {


        return {
            activeImg:0,
            options:[
            {
              'material':'selectbox'
            },
            {
              ['gift'+this.data.id]:'selectbox'
            }
           ],
           store:{
             'material':2,
             ['gift'+this.data.id]:1
           }
          }
        },

        props:['data','giftOptionValues','giftOptions'],

        ready: function () {



        },
        mounted:function(){

        },



        computed: {
          resultImg:function(i){
            return this.data.images[this.activeImg];

          },
          modalName:function(){
            return 'for-her'+this.data.id;
          },

         totalPrice:function(){
           let material=1;
            let price=this.giftOptionValues['gift'+this.data.id][this.store['gift'+this.data.id]-1].price.material[this.store.material];
            console.log(price);
            return currencyFormatter.format(price, { code: 'RUB',precision:0});
          }


        }
    }
</script>
