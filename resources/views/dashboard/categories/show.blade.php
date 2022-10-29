@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{ $category->name }}</h1>
    <button data-toggle="modal" data-target="#new_tire_modal" class="btn btn-app mt-3">Додај нова гума</button>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $category->products->count() }}</h3>
                    <p>Вкупно Гуми на залиха</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $summer->count() }}</h3>
                    <p>Летни</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $winter->count() }}</h3>
                    <p>Зимски</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $all_season->count() }}</h3>
                    <p>Сите Сезони</p>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <div class="modal" tabindex="-1" role="dialog" id="new_tire_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Креирај нова гума</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('categories.tires.store', $category->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                            <div class="row">
                                <div class="col-5">
                                    <label for="brand">Бренд</label>
                                    <select class="form-control" name="brand" id="brand">
                                        <option value="">Избери бренд....</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-5" hidden id="pattern_div">
                                    @include('dashboard.categories.partials.patterns')
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-3">
                                    <label for="width">Ширина</label>
                                    <input type="number" class="form-control" placeholder="205" name="width" id="width">
                                </div>
                                <div class="col-3">
                                    <label for="height">Висина</label>
                                    <input type="number" class="form-control" placeholder="55" name="height" id="height">
                                </div>
                                <div class="col-3">
                                    <label for="radius">Радиус</label>
                                    <input type="number" class="form-control" placeholder="16" name="radius" id="radius">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <label class="form-label" for="price">Цена</label>
                                    <input class="form-control" type="number" name="price" id="price">
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Внеси</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Откажи</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).on('change', '#brand', function () {
            let brand_id = $(this).val()
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('get.patterns') }}",
                type: 'post',
                data: { brand_id },
                success: function (response) {
                    $('#pattern_div')
                        .empty()
                        .html(response)
                        .attr('hidden', false)
                }
            })
        })
    </script>
@stop
