<modal name="save-to-email" height="auto" adaptive v-cloak >
  <button @click="$modal.hide('save-to-email')" class="modal-close">
    <img src="images/close.png" alt="close"/>
  </button>
  <h3 class="modal-header">Сохранить на почту</h3>
  <div class="modal-body">
    <form name="save" action="/savetoemail" method="post" @submit.prevent="saveToEmail" id="savetoemail-form">
        {{csrf_field()}}
      <div class="form-group">
         <input type="text" class="form-control" name="name" value="" placeholder="Имя" />

      </div>
       <div class="form-group">
         <input type="text" class="form-control" name="email" value="" placeholder="Email" />
       </div>
        <div class="form-group">
          <input type="text" class="form-control" name="phone" value="" placeholder="Телефон" />
       </div>
       <div class="form-group">
         <button type="submit" class="form-control" name="submit" @click="$modal.hide('save-to-email')">Отправить</button>
      </div>

    </form>
  </div>
</modal>
<modal name="call-order" height="auto" adaptive v-cloak >
  <button @click="$modal.hide('call-order')" class="modal-close">
      <img src="images/close.png" alt="close"/>
  </button>
  <h3 class="modal-header">Заказать звонок</h3>
  <div class="modal-body">
    <form name="save" action="/callorder" method="post" @submit.prevent="callOrder" id="call-order-form">
        {{csrf_field()}}
      <div class="form-group">
         <input type="text" class="form-control" name="name" value="" placeholder="Имя" />

      </div>

        <div class="form-group">
          <input type="text" class="form-control" name="phone" value="" placeholder="Телефон" required />
       </div>
       <div class="checkbox">
        <label>
          <input type="checkbox" required> Согласен с <a href="/policy">политикой конфиденциальности</a>
        </label>
      </div>
       <div class="form-group">
         <button type="submit" class="form-control" name="submit" @click="$modal.hide('call-order')">Отправить</button>
      </div>

    </form>
  </div>
</modal>
<modal name="guest-order" height="auto" adaptive v-cloak >
  <button @click="$modal.hide('guest-order')" class="modal-close">
      <img src="images/close.png" alt="close"/>
  </button>
  <h3 class="modal-header">Записаться в студию</h3>
  <div class="modal-body">
    <form name="save" action="/callorder" method="post" @submit.prevent="guestOrder" id="guest-order-form">
        {{csrf_field()}}
      <div class="form-group">
         <input type="text" class="form-control" name="name" value="" placeholder="Имя" />

      </div>

        <div class="form-group">
          <input type="text" class="form-control" name="phone" value="" placeholder="Телефон" required />
       </div>
       <div class="checkbox">
        <label>
          <input type="checkbox" required> Согласен с <a href="/policy">политикой конфиденциальности</a>
        </label>
      </div>
       <div class="form-group">
         <button type="submit" class="form-control" name="submit" @click="$modal.hide('guest-order')">Отправить</button>
      </div>

    </form>
  </div>
</modal>
<modal name="ring-order" height="auto" adaptive v-cloak >
  <button @click="$modal.hide('ring-order')" class="modal-close">
      <img src="images/close.png" alt="close"/>
  </button>
  <h3 class="modal-header">Заказать</h3>
  <div class="modal-body">
    <form name="save" action="/ringorder" method="post" @submit.prevent="ringOrder" id="ring-order-form">
        {{csrf_field()}}
      <div class="form-group">
         <input type="text" class="form-control" name="name" value="" placeholder="Имя" />

      </div>
      <div class="form-group">
        <input type="text" class="form-control" name="email" value="" placeholder="Email" required />
     </div>
        <div class="form-group">
          <input type="text" class="form-control" name="phone" value="" placeholder="Телефон" required />
       </div>

       <div class="form-group">
         <button type="submit" class="form-control" name="submit" @click="$modal.hide('ring-order')">Отправить</button>
      </div>

    </form>
  </div>
</modal>

<modal name="gift-order" height="auto" adaptive v-cloak >
  <button @click="$modal.hide('gift-order')" class="modal-close">
      <img src="images/close.png" alt="close"/>
  </button>
  <h3 class="modal-header">Заказать <span v-text="gifts[activeGift].title"></span></h3>
  <div class="modal-body">
    <form name="save" action="/ringorder" method="post" @submit.prevent="orderGift" id="gift-order-form">
        {{csrf_field()}}
      <div class="form-group">
         <input type="text" class="form-control" name="name" value="" placeholder="Имя" />

      </div>
      <div class="form-group">
        <input type="text" class="form-control" name="email" value="" placeholder="Email" required />
     </div>
        <div class="form-group">
          <input type="text" class="form-control" name="phone" value="" placeholder="Телефон" required />
       </div>

       <div class="form-group">
         <button type="submit" class="form-control" name="submit" >Отправить</button>
      </div>
      <input type="hidden" name="gift" :value="gifts[activeGift-1].title" />
      <input type="hidden" name="giftid" :value="gifts[activeGift-1].id" />
    </form>
  </div>
</modal>
<modal name="help-order1" height="auto" adaptive v-cloak >
  <button @click="$modal.hide('help-order1')" class="modal-close">
      <img src="images/close.png" alt="close"/>
  </button>
  <h3 class="modal-header">Помощь специалиста</h3>
  <div class="modal-body">
    <form name="save" action="/helporder" method="post" @submit.prevent="helpOrder(1)" id="help-order1-form">
        {{csrf_field()}}
      <div class="form-group">
         <input type="text" class="form-control" name="name" value="" placeholder="Имя" />

      </div>
      <div class="form-group">
        <input type="text" class="form-control" name="email" value="" placeholder="Email" required />
     </div>
        <div class="form-group">
          <input type="text" class="form-control" name="phone" value="" placeholder="Телефон" required />
       </div>

       <div class="form-group">
         <button type="submit" class="form-control" name="submit" @click="$modal.hide('help-order1')">Отправить</button>
      </div>
      <input type="hidden" name="step" value="1" />
    </form>
  </div>
</modal>
<modal name="help-order2" height="auto" adaptive v-cloak >
  <button @click="$modal.hide('help-order2')" class="modal-close">
      <img src="images/close.png" alt="close"/>
  </button>
  <h3 class="modal-header">Помощь специалиста</h3>
  <div class="modal-body">
    <form name="save" action="/helporder" method="post" @submit.prevent="helpOrder(2)" id="help-order2-form">
        {{csrf_field()}}
      <div class="form-group">
         <input type="text" class="form-control" name="name" value="" placeholder="Имя" />

      </div>
      <div class="form-group">
        <input type="text" class="form-control" name="email" value="" placeholder="Email" required />
     </div>
        <div class="form-group">
          <input type="text" class="form-control" name="phone" value="" placeholder="Телефон" required />
       </div>

       <div class="form-group">
         <button type="submit" class="form-control" name="submit" @click="$modal.hide('help-order2')">Отправить</button>
      </div>
      <input type="hidden" name="step" value="2" />
    </form>
  </div>
</modal>
<modal name="help-order3" height="auto" adaptive v-cloak >
  <button @click="$modal.hide('help-order3')" class="modal-close">
      <img src="images/close.png" alt="close"/>
  </button>
  <h3 class="modal-header">Помощь специалиста</h3>
  <div class="modal-body">
    <form name="save" action="/helporder" method="post" @submit.prevent="helpOrder(3)" id="help-order3-form">
        {{csrf_field()}}
      <div class="form-group">
         <input type="text" class="form-control" name="name" value="" placeholder="Имя" />

      </div>
      <div class="form-group">
        <input type="text" class="form-control" name="email" value="" placeholder="Email" required />
     </div>
        <div class="form-group">
          <input type="text" class="form-control" name="phone" value="" placeholder="Телефон" required />
       </div>

       <div class="form-group">
         <button type="submit" class="form-control" name="submit" @click="$modal.hide('help-order3')">Отправить</button>
      </div>
        <input type="hidden" name="step" value="3" />
    </form>
  </div>
</modal>

<modal name="thanks" height="auto" adaptive v-cloak>
  <button @click="$modal.hide('thanks')" class="modal-close">
      <img src="images/close.png" alt="close"/>
  </button>
  <h3 class="modal-header">Спасибо</h3>
  <div class="modal-body">
    <p>Ваш персональный менеджер свяжется с Вами в ближайшее время! </p>
  </div>
</modal>
