@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Залиха</h1>
@stop


@section('content')
<div class="container">
  <form id="search" action="" method="get">

    <div class="row">
      <div class="col-3">
        <div>
          <input id="summer" type="checkbox" name="summer">
          <label for="summer">Летни</label>
        </div>
        <div>
          <input id="winter" type="checkbox" name="winter">
          <label for="winter">Зимски</label>
        </div>
        <div>
          <input id="allseason" type="checkbox" name="allseason">
          <label for="allseason">Сите Сезони</label>
        </div>
      </div>
      <div class="col-3">
        <div class="form-group">
          <label for="location">Локација</label>
          <input type="text" class="form-control" name="location">
        </div>
      </div>
    </div>
    <div class="row mb-3">
      <div class="ool-6">
        <button type="submit" class="btn btn-block btn-primary">Пребарај</button>
      </div>
    </div>
  </form>
  <div id="table">
    @include('dashboard.partials._stock_table')
  </div>
 </div>
@endsection

@section('js')
<script>
  $(document).on('submit', '#search', function(e) {
    e.preventDefault()
    let data = $(this).serialize()
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "GET",
                url: "{{ route('search.product') }}",
                data: data,
                success: function (data) {
                  console.log(data)
                   $('#table').empty().html(data)
                }
            })
  })
</script>

@endsection
