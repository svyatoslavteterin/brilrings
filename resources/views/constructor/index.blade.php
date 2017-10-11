@extends('layout')


@section('content')

<section id="construct-app">
  <div class="container">
      <div class="steps row">
        <div class="col-md-4 steps__item">
          <div class="steps__item__top">Этап №1</div>
          <div class="steps__item__title">Выбрать оправу</div>
        </div><!-- steps__item -->
        <div class="col-md-4 steps__item">
          <div class="steps__item__top">Этап №2</div>
          <div class="steps__item__title">Выбрать камень</div>
        </div><!-- steps__item -->
        <div class="col-md-4 steps__item">
          <div class="steps__item__top">Этап №3</div>
          <div class="steps__item__title">Завершить кольцо</div>
        </div><!-- steps__item -->
      </div>
      <materials></materials>
      <div id="app-steps-container">
          <div class="app-steps-item active" data-stepid="1">
            <div class="base" id="base">
                <div class="row">
                  <div class="col-md-4 base__item">
                    <div class="base__item__container">
                      <div class="base__item__img"><img src="images/base/1.jpg" alt="base1"/> </div>
                      <div class="base__item__title">Элегантная классика </div>
                      <div class="base__item__price">22 175 рублей</div>
                      <div class="base__item__btn"><a href="#" class="btn btn-choose" data-base="1">Выбрать</a></div>
                    </div>
                  </div><!-- /base__item-->
                  <div class="col-md-4 base__item">
                    <div class="base__item__container">
                      <div class="base__item__img"><img src="images/base/1.jpg" alt="base1"/> </div>
                      <div class="base__item__title">Элегантная классика </div>
                      <div class="base__item__price">22 175 рублей</div>
                      <div class="base__item__btn"><a href="#" class="btn btn-choose" data-base="1">Выбрать</a></div>
                    </div>
                  </div><!-- /base__item-->
                  <div class="col-md-4 base__item">
                    <div class="base__item__container">
                      <div class="base__item__img"><img src="images/base/1.jpg" alt="base1"/> </div>
                      <div class="base__item__title">Элегантная классика </div>
                      <div class="base__item__price">22 175 рублей</div>
                      <div class="base__item__btn"><a href="#" class="btn btn-choose" data-base="1">Выбрать</a></div>
                    </div>
                  </div><!-- /base__item-->
                  <div class="col-md-4 base__item">
                    <div class="base__item__container">
                      <div class="base__item__img"><img src="images/base/1.jpg" alt="base1"/> </div>
                      <div class="base__item__title">Элегантная классика </div>
                      <div class="base__item__price">22 175 рублей</div>
                      <div class="base__item__btn"><a href="#" class="btn btn-choose" data-base="1">Выбрать</a></div>
                    </div>
                  </div><!-- /base__item-->
                  <div class="col-md-4 base__item">
                    <div class="base__item__container">
                      <div class="base__item__img"><img src="images/base/1.jpg" alt="base1"/> </div>
                      <div class="base__item__title">Элегантная классика </div>
                      <div class="base__item__price">22 175 рублей</div>
                      <div class="base__item__btn"><a href="#" class="btn btn-choose" data-base="1">Выбрать</a></div>
                    </div>
                  </div><!-- /base__item-->
                  <div class="col-md-4 base__item">
                    <div class="base__item__container">
                      <div class="base__item__img"><img src="images/base/1.jpg" alt="base1"/> </div>
                      <div class="base__item__title">Элегантная классика </div>
                      <div class="base__item__price">22 175 рублей</div>
                      <div class="base__item__btn"><a href="#" class="btn btn-choose" data-base="1">Выбрать</a></div>
                    </div>
                  </div><!-- /base__item-->

                </div><!-- /row-->

            </div> <!-- /base-->

          </div><!-- app-steps-item -->
          <div class="app-steps-item" data-stepid="2">
            <div class="row">
              <div class="col-md-2">
                  <div class="model" id="model">
                      <p>Варианты оправ</p>
                      <div class="model__item"><img src="images/base/1/material/1/1-small.jpg" alt=""/></div>
                      <div class="model__item"><img src="images/base/2/material/1/1-small.jpg" alt=""/> </div>
                      <div class="model__item"><img src="images/base/3/material/1/1-small.jpg" alt=""/> </div>
                      <div class="model__item"><img src="images/base/4/material/1/1-small.jpg" alt=""/> </div>
                      <div class="model__item"><img src="images/base/5/material/2/1-small.jpg" alt=""/> </div>
                      <div class="model__item"><img src="images/base/6/material/2/1-small.jpg" alt=""/> </div>
                      <div class="model__item"><img src="images/base/7/material/2/1-small.jpg" alt=""/> </div>
                  </div>

              </div>
              <div class="col-md-6">
                <img id="result-img" src="images/base/1/material/1/1.jpg" alt=""/>
              </div>
              <div class="col-md-4">
                <div class="model-images">
                    <ul>
                      <li><a href="#"><img src="images/base/1/material/1/1-small.jpg" alt="" /></a></li>
                      <li><a href="#"><img src="images/base/1/material/1/2-small.jpg" alt="" /></a></li>
                      <li><a href="#"><img src="images/base/1/material/1/3-small.jpg" alt="" /></a></li>

                    </ul>
                </div><!-- model-images -->
                <div class="model-info">
                  <div class="model-title">Элегантная классика</div>
                  <div class="model-desc">лассическая оправа доступна для заказа под центральный камень любого диаметра.</div>
                  <div class="model-config">
                      <select name="material">
                          <option value="1">Белое золото</option>
                          <option value="2">Белое золото</option>
                          <option value="3">Белое золото</option>
                          <option value="4">Белое золото</option>
                          <option value="5">Белое золото</option>
                          <option value="6">Белое золото</option>
                          <option value="7">Белое золото</option>
                      </select>
                      <select name="stone-type">
                          <option value="1">Бриллиант</option>
                      </select>
                  </div><!-- /model-config -->
                </div><!-- /model-info -->


              </div>
            </div>
          </div><!-- app-steps-item -->
          <div class="app-steps-item" data-stepid="3">
            <div class="row">
              <div class="col-md-3 ring-config">
                  <div class="ring-config__item">
                    <select id="ring-stone-type">
                        <option value="1">Бриллиант</option>
                        <option value="2">Муссанит</option>
                    </select>
                  </div><!-- /ring-config__item-->
                  <div class="ring-config__item">
                    <div class="ring-config__item__title">Форма</div>
                    <select id="ring-stone-shape">
                        <option value="1"></option>
                        <option value="2"></option>
                        <option value="3"></option>
                        <option value="4"></option>
                        <option value="5"></option>
                        <option value="6"></option>
                        <option value="7"></option>
                    </select>
                  </div><!-- /ring-config__item-->
                  <div class="ring-config__item">
                    <div class="ring-config__item__title">Вес</div>
                    <select id="ring-stone-weight">
                        <option value="1"></option>
                        <option value="2"></option>
                        <option value="3"></option>
                        <option value="4"></option>
                        <option value="5"></option>
                        <option value="6"></option>
                        <option value="7"></option>
                    </select>
                  </div><!-- /ring-config__item-->
                  <div class="ring-config__item">
                    <div class="ring-config__item__title">Диаметр</div>
                    <select id="ring-stone-size">
                        <option value="1"></option>
                        <option value="2"></option>
                        <option value="3"></option>
                        <option value="4"></option>
                        <option value="5"></option>
                        <option value="6"></option>
                        <option value="7"></option>
                    </select>
                    <div class="ring-config__item">
                      <div class="ring-config__item__title">Цвет</div>
                      <select id="ring-stone-color">
                          <option value="1"></option>
                          <option value="2"></option>
                          <option value="3"></option>
                          <option value="4"></option>
                          <option value="5"></option>
                          <option value="6"></option>
                          <option value="7"></option>
                      </select>
                    </div><!-- /ring-config__item-->
                    <div class="ring-config__item">
                      <div class="ring-config__item__title">Чистота</div>
                      <select id="ring-stone-purity">
                          <option value="1"></option>
                          <option value="2"></option>
                          <option value="3"></option>
                          <option value="4"></option>
                          <option value="5"></option>
                          <option value="6"></option>
                          <option value="7"></option>
                      </select>
                    </div><!-- /ring-config__item-->
                  </div><!-- /ring-config__item-->
              </div>
              <div class="col-md-6 ring-result-img">
                  <img src='images/base/1/material/1/shape/1/weight/1/' alt=""/>
              </div>

              <div class="col-md-3 ring-result">
                  <div class="ring-result-title">Бриллиант</div>
                  <div class="ring-result-price">22 175 руб</div>
                  <table class="ring-config-table">
                    <tr id="ring-config-shape">
                      <td>Форма огранки</td>
                      <td>Круг</td>
                    </tr>
                    <tr id="ring-config-weight">
                      <td>Вес камня</td>
                      <td>0.17 ct</td>
                    </tr>
                    <tr id="ring-config-color">
                      <td>Цвет</td>
                      <td>4</td>
                    </tr>
                    <tr id="ring-config-color">
                      <td>Чистота</td>
                      <td>6</td>
                    </tr>
                    <tr id="ring-config-color">
                      <td>Размер</td>
                      <td>3.50 мм</td>
                    </tr>
                  </table>
              </div>

            </div>


          </div>

          <div id="total-params" class="hide">
            <div class="total-price-title">Итоговая цена:</div>
            <div class="total-price">22 175 руб</div>

            <a href="#" class="btn btn-next-step">Выбрать</a>
            <a href="#" class="btn btn-help">Помощь специалиста</a>
          </div>
      </div><!-- /app-steps-container -->

  </div>

</section><!-- /construct-app-->


@endsection


@section('footer')
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
@endsection
