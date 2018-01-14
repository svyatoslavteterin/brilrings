<nav class="mainnav navbar">
  <div class="navbar-header">
     <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainnavbar-collapse" aria-expanded="false">
       <span class="sr-only">Toggle navigation</span>
       <span class="icon-bar"></span>
       <span class="icon-bar"></span>
       <span class="icon-bar"></span>
     </button>
   </div>
    <div class="collapse navbar-collapse" id="mainnavbar-collapse">
      <ul>
        <li class="{{ Request::path() == 'constructor/base' ? 'active' : '' }}"><a href="constructor/base">Кольца</a></li>
        <li class="{{ Request::path() == 'constructor/stone' ? 'active' : '' }}"><a href="constructor/stone">Бриллианты</a></li>
        <li class="{{ Request::path() == 'for-her' ? 'active' : '' }}"><a href="for-her">Подарок для нее</a></li>
        <li class="{{ Request::path() == 'about' ? 'active' : '' }}"><a href="about">О нас</a></li>
        <li class="{{ Request::path() == 'blog' ? 'active' : '' }}"><a href="/blog">О нас</a></li>
        <li class="{{ Request::path() == 'contacts' ? 'active' : '' }}"><a href="contacts">Контакты</a></li>
      </ul>
    </div>
</nav>
