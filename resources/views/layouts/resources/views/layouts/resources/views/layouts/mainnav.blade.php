<nav class="mainnav">
    <ul>
      <li class="{{ Request::path() == 'constructor/base' ? 'active' : '' }}"><a href="constructor/base">Кольца</a></li>
      <li class="{{ Request::path() == 'constructor/stone' ? 'active' : '' }}"><a href="constructor/stone">Бриллианты</a></li>
      <li class="{{ Request::path() == 'handmade' ? 'active' : '' }}"><a href="handmade">Своими руками</a></li>
      <li class="{{ Request::path() == 'about' ? 'active' : '' }}"><a href="about">О нас</a></li>
      <li class="{{ Request::path() == 'blog' ? 'active' : '' }}"><a href="blog">Блог</a></li>
      <li class="{{ Request::path() == 'contacts' ? 'active' : '' }}"><a href="contacts">Контакты</a></li>
    </ul>
</nav>
