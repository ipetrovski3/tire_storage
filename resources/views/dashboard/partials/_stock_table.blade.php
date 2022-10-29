<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Шифра</th>
      <th scope="col">Назив</th>
      <th scope="col">Сезона</th>
      <th scope="col">Цена</th>
      <th scope="col">Лагер</th>
    </tr>
  </thead>
  <tbody>
    @foreach($products as $product)
    <tr>
      <th scope="row">{{ $product->code }}</th>
      <td>{{ $product->name }}</td>
      <td>Летни</td>
      <td>{{ $product->price }}</td>
      <td>{{ $product->stock }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
