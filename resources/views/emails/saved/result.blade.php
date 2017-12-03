<table>

  <tr>

    <td width="60%"><img src="{{$result_img}}"></td>

    <td width="40%">
<h2>{{$ringOptionValues['base'][$session['base']]->title }}</h2>
<div class="ring-info__desc">{{$ringOptionValues['base'][$session['base']]->desc }}</div>

<h3>Оправа</h3>

<table>
  <tr>
    <th>Материал</th>
    <td>{{$ringOptionValues['material'][$session['material']]->title }}</td>
  </tr>

</table>

<h3>{{$ringOptionValues['stone'][$session['stone']]->title }}</h3>

<table>
  <tr>
    <th>Форма огранки</th>
    <td>{{$ringOptionValues['shape'][$session['shape']]->title }}</td>
  </tr>
  <tr>
    <th>Вес камня</th>
    <td>{{$ringOptionValues['weight'][$session['weight']]->title }} ct</td>
  </tr>
  <tr>
    <th>Качество</th>
    <td>{{$ringOptionValues['color'][$session['color']]->title }}</td>
  </tr>
  <tr>
    <th>Диаметр</th>
    <td>{{$ringOptionValues['size'][$session['size']]->title }} мм</td>
  </tr>




</table>


<table>
  <tr>
    <th>Стоимость</th>
    <td>{{$total_price}}₽</td>
  </tr>
  <tr>
    <th>Сcылка</th>
    <td>http://brilliantrings.ru/constructor/base/{{$session['base']}}/{{$session['material']}}/{{$session['shape']}}/{{$session['weight']}}/{{$session['color']}}/{{$session['stone']}}/</td>
  </tr>

</table>

</td>
</tr>

</table>
