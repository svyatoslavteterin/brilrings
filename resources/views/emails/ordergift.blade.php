<table>
  <tr>
    <th>Подарок</th>
    <td>{{$data['gift']}}</td>
  </tr>
  <tr>
    <td>{{$giftOptionValues['material'][$store['material']]->title }}</td>
    <td>{{$giftOptionValues['material'][$store['material']]->desc }}</td>
  </tr>
  <tr>
    <td>{{$giftOptionValues['gift'.$giftid][$store['gift'.$giftid]]->title }}</td>
    <td>{{$giftOptionValues['gift'.$giftid][$store['gift'.$giftid]]->desc }}</td>
  </tr>
  <tr>
    <th>Подарок</th>
    <td>{{$data['gift']}}</td>
  </tr>
  <tr>
    <th>Имя</th>
    <td>{{$data['name']}}</td>
  </tr>
  <tr>
    <th>Email</th>
    <td>{{$data['email']}}</td>
  </tr>
  <tr>
    <th>Телефон</th>
    <td>{{$data['phone']}}</td>
  </tr>
</table>
