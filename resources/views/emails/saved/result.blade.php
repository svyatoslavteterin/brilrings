<h2>{{$base}}</h2>
<div class="ring-info__desc"> </div>

<h3>Оправа</h3>

<table>
  <tr>
    <th>Материал<th>
    <td>{{$session->material}}<td>
  </tr>

</table>

<h3>{{$session->stone}}</h3>

<table>
  <tr>
    <th>Форма огранки<th>
    <td>{{$session->shape}}<td>
  </tr>
  <tr>
    <th>Вес камня<th>
    <td>{{$session->weight}}<td>
  </tr>
  <tr>
    <th>Качество<th>
    <td>{{$session->color}}<td>
  </tr>
  <tr>
    <th>Диаметр<th>
    <td>{{$session->size}}<td>
  </tr>

</table>
