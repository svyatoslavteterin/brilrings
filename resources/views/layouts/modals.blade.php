<modal name="save-to-email">
  <button @click="$modal.hide('save-to-email')" class="modal-close">
    ❌
  </button>
  <h3 class="modal-header">Сохранить на почту</h3>
  <div class="modal-body">
    <form name="save" action="/savetoemail" method="post" @submit.prevent="saveToEmail" id="savetoemail-form">
        {{csrf_field()}}
      <div class="form-group">
         <input type="text" name="name" value="" placeholder="Имя" />

      </div>
       <div class="form-group">
         <input type="text" name="email" value="" placeholder="Email" />
       </div>
        <div class="form-group">
          <input type="text" name="phone" value="" placeholder="Телефон" />
       </div>
       <div class="form-group">
         <button type="submit" name="submit" @click="$modal.hide('save-to-email')">Отправить</button>
      </div>

    </form>
  </div>
</modal>
<modal name="call-order">
  <button @click="$modal.hide('call-order')" class="modal-close">
    ❌
  </button>
  <h3 class="modal-header">Заказать звонок</h3>
  <div class="modal-body">
    <form name="save" action="/callorder" method="post" @submit.prevent="callOrder" id="call-order-form">
        {{csrf_field()}}
      <div class="form-group">
         <input type="text" name="name" value="" placeholder="Имя" />

      </div>

        <div class="form-group">
          <input type="text" name="phone" value="" placeholder="Телефон" required />
       </div>
       <div class="checkbox">
        <label>
          <input type="checkbox" required> Согласен с <a href="/policy">политикой конфиденциальности</a>
        </label>
      </div>
       <div class="form-group">
         <button type="submit" name="submit" @click="$modal.hide('save-to-email')">Отправить</button>
      </div>

    </form>
  </div>
</modal>
<modal name="guest-order">
  <button @click="$modal.hide('guest-order')" class="modal-close">
    ❌
  </button>
  <h3 class="modal-header">Записаться в студию</h3>
  <div class="modal-body">
    <form name="save" action="/callorder" method="post" @submit.prevent="guestOrder" id="guest-order-form">
        {{csrf_field()}}
      <div class="form-group">
         <input type="text" name="name" value="" placeholder="Имя" />

      </div>

        <div class="form-group">
          <input type="text" name="phone" value="" placeholder="Телефон" required />
       </div>
       <div class="checkbox">
        <label>
          <input type="checkbox" required> Согласен с <a href="/policy">политикой конфиденциальности</a>
        </label>
      </div>
       <div class="form-group">
         <button type="submit" name="submit" @click="$modal.hide('save-to-email')">Отправить</button>
      </div>

    </form>
  </div>
</modal>
<modal name="ring-order">
  <button @click="$modal.hide('ring-order')" class="modal-close">
    ❌
  </button>
  <h3 class="modal-header">Заказать</h3>
  <div class="modal-body">
    <form name="save" action="/callorder" method="post" @submit.prevent="ringOrder" id="ring-order-form">
        {{csrf_field()}}
      <div class="form-group">
         <input type="text" name="name" value="" placeholder="Имя" />

      </div>
      <div class="form-group">
        <input type="text" name="email" value="" placeholder="Email" required />
     </div>
        <div class="form-group">
          <input type="text" name="phone" value="" placeholder="Телефон" required />
       </div>

       <div class="form-group">
         <button type="submit" name="submit" @click="$modal.hide('save-to-email')">Отправить</button>
      </div>

    </form>
  </div>
</modal>
