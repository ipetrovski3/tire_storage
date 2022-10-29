<div>
    <h4 id="company_title">Купувач {{ $company->name }}</h4>
</div>
<table class="table">
    <thead>
    <tr>
        <th>Шифра</th>
        <th>Назив на артикл</th>
        <th>Количина</th>
        <th>Ед цена без ДДВ</th>
        <th>ДДВ</th>
        <th>Цена со ДДВ</th>
        <th>Вкупно со ДДВ</th>
        <th> / </th>
    </tr>
    </thead>
    <tbody id="table_body">
    @foreach ($all_items as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->qty }}</td>
            <td>{{ number_format($item->price, 2, ',', '.') }}</td>
            <td>{{ floatval($item->tax()) }}</td>
            <td>{{ number_format($item->price + $item->tax, 2, ',', '.') }}</td>
            <td>{{ number_format(round(($item->price + $item->tax) * $item->qty), 2, ',', '.') }}</td>
            <td>
                <button type="button" data-product="{{ $item->rowId }}" class="btn btn-danger remove">
                    <i class="fas fa-times"></i>
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="float-right mt-2">
    <p class="my-0"> Вкупна Цена без ДДВ: <strong>{{ $subtotal }} ден.</strong></p>
    <hr>
    <p class="my-0">ДДВ: <strong>{{ $tax }} ден.</strong></p>
    <hr>
    <p class="my-0">Вкупно: <strong>{{ $total }} ден.</strong></p>
</div>
<hr>
<button type="button" id="store_invoice" class="btn btn-success mt-4"><i class="fas fa-save"></i> Потврди</button>
