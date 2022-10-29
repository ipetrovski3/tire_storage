@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Фактура</h1>
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3">
            <label for="client">ДО:</label>
            <select name="client" name="client" class="form-control input-sm select2" id="client">
                <option value="">Избери клиент....</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
        <div hidden class="col-1 ml-0 pl-0">
            <label for=""></label>
            <div class="buttonload">
                <i class="fa fa-spinner fa-spin"></i>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <label for="datepicker">Датум</label>
            <input id="datepicker" class="form-control" value=""  type="date" name="date">
        </div>
    </div>

    <table class="table mt-4">
        <thead>
        <tr>
            <th width="10%" scope="col">Шифра</th>
            <th scope="col">Назив</th>
            <th width="10%" scope="col">Кол</th>
            <th width="15%" scope="col">Ед Цена</th>
            <th width="20%" scope="col">Вк Цена</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><input class="form-control" id="product_code" type="text" disabled></td>
            <td><select id="product_id" class="form-control select2" type="text">
                    <option value=""></option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select></td>
            <td><input class="form-control total_price" id="qty" type="number" value="0"></td>
            <td><input class="form-control total_price" id="price" type="text" value="0"></td>
            <td><input class="form-control" type="text" id="total_price" disabled value="0"></td>
            <td>
                <button type="button" id="confirm_product" class="btn btn-success"><i class="fas fa-check"></i></button>
            </td>
        </tr>
        </tbody>
    </table>

    <div id="invoiced_full"></div>
</div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
        $("#datepicker").datepicker({
            dateFormat: "dd-mm-yy"
        });
        $("#datepicker").datepicker('setDate', 'today')
    </script>
    <script>

        $(document).on('click', '.remove', function () {
            let product = $(this).data('product')
            let client = $('#client').val()
            $.ajax({
                type: "POST",
                url: "{{ route('remove.product') }}",
                data: {
                    product, client
                },
                success: function (data) {
                    $('#invoiced_full').empty()
                    $('#invoiced_full').append(data)
                }
            })
        })

        $(document).on('keyup, change', '#qty, #price', function () {
            let price = $('#price').val()
            let qty = $('#qty').val()
            $('#total_price').val(formatter.format(price * qty))
        })
        $(document).on('change', '#product_id', function () {
            let product_id = $(this).val()

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('find.product') }}",
                data: {
                    product_id,
                },
                success: function (data) {
                    $('#product_code').val(data)
                }
            })
        })
        $(document).on('click', '#confirm_product', function () {
            // let ddv = $('#ddv_check').prop("checked") == true ? 1 : 0;
            let product_id = $('#product_id').val()
            let qty = $('#qty').val()
            let price = $('#price').val()
            let client = $('#client').val()

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('add.product') }}",
                data: {
                    product_id,
                    qty,
                    price,
                    client,
                },
                success: function (data) {
                    console.log(data)
                    $('#invoiced_full').empty()
                    $('#invoiced_full').append(data)
                    $("#product_name").val("");
                }
            })
        })
        var formatter = new Intl.NumberFormat('mk-MK', {
            style: 'currency',
            currency: 'MKD'
        })

        $(document).on('click', '#store_invoice', function () {
            let date = $("#datepicker").val()
            let company_id = $('#client').val()
            let extra = $('#extra').val()
            $.ajax({
                type: "POST",
                url: "{{ route('store.invoice') }}",
                data: {
                    company_id,
                    date,
                    extra
                },
                success: function (data) {
                    Swal.fire({
                        html: "Успешно креиран документ!",
                        confirmButtonColor: '#198754'
                    })
                    console.log(data)
                    // $('#invoiced_full').empty()
                }
            })

        })
    </script>
@endsection
