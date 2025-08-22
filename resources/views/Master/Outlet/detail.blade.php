@php
    $title = $outlet->name;
@endphp
@extends('layouts.main')

@section('css')
    <style>
        .leaflet-control-locate {
            background-color: white;
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 1px 4px rgba(0,0,0,0.3);
        }
    </style>
@endsection

@section('header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="page-header">
            <h3 class="fw-bold mb-3">{{ $outlet->name }}</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ url('/') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Master</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/master/outlet') }}">Outlet</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ $outlet->name }}</a>
                </li>
            </ul>

        </div>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductOutletModal"><i class="fas fa-plus"></i> Tambah Produk</button>
    </div>
@endsection

@section('container')
    <div class="card" style="min-height: 60vh">
        <div class="card-body">
            <div id="dataGrid"></div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addProductOutletModal" tabindex="-1" aria-labelledby="addProductOutletModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form onsubmit="add()">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addProductOutletModalLabel">Tambah Produk</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="" class="form-label">Produk</label>
                            <select name="product" id="product" class="form-select" required>
                                <option value="" selected disabled>Pilih Produk</option>
                                @foreach($products_can_added as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Harga</label>
                            <input type="number" name="price" id="price" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editOutletModal" tabindex="-1" aria-labelledby="editOutletModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form onsubmit="update()">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editOutletModalLabel">Ubah Produk</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="product_outlet_id" id="edit_id">
                        <div class="mb-3">
                            <label for="" class="form-label">Produk</label>
                            <input type="text" class="form-control" id="edit_product" name="product" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Status</label>
                            <select name="active" id="edit_active" class="form-select">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Harga</label>
                            <input type="number" name="price" id="edit_price" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {

            const product_can_added = @json($products_can_added);

            $('#product').selectize({
                onChange: function(value) {
                    const product = product_can_added.find(item => item.id == value);
                    $('#price').val(product.default_price);
                }
            })

            const data = @json($products);

            $('#dataGrid').dxDataGrid({
                dataSource: data,
                columnHidingEnabled: true,
                columnAutoWidth: true,
                rowAlternationEnabled: true,
                filterRow: {
                    visible: true,
                    applyFilter: "auto"
                },
                searchPanel: {
                    visible: true
                },
                grouping: {
                    autoExpandAll: true
                },
                groupPanel: {
                    visible: true
                },
                headerFilter: {
                    visible: true,
                    applyFilter: "auto"
                },
                paging: false,
                height: viewportHeight,
                summary: {
                    groupItems: [
                        {
                            summaryType: 'count'
                        }
                    ]
                },
                columns: [
                    {dataField: 'product_name', caption: 'Nama Produk'},
                    {dataField: 'price', caption: 'Harga'},
                    {
                        dataField: 'active',
                        dataType: 'string',
                        cellTemplate: function (container, options) {
                            if(options.value == 1) {
                                $(container).html(`<div class="px-2 py-1 bg-success-subtle rounded-pill" style="width: min-content; cursor: pointer">Active</div>`)
                            } else {
                                $(container).html(`<div class="px-2 bg-danger-subtle rounded-pill" style="width: min-content; cursor: pointer">Non Active</div>`)
                            }
                        }
                    },
                    {
                        caption: 'Action',
                        cellTemplate: function (container, options) {
                            const button = $('<button>').addClass('btn btn-primary btn-sm rounded-pill').html(`<i class="fas fa-pen"></i>`).on('click', function() {
                                edit(options.data)
                            })

                            $(container).append(button)

                        }
                    }
                ]
            })


        })

        function add() {
            event.preventDefault()

            const data = $(event.target).serializeArray()

            $.ajax({
                url: '/master/outlet/{{ $outlet->id }}/addproduct',
                method: 'POST',
                data: data,
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                beforeSend: () => $('.preloader').show(),
                complete: () => $('.preloader').fadeOut(),
                success: data => {
                    Swal.fire({
                        icon: 'success',
                        text: 'Data saved!!',
                        showConfirmButton: false
                    }).then(_ => {
                        location.reload()
                    })
                },
                error: err => Swal.fire({
                    icon: 'error',
                    html: err['responseJSON'] ? err.responseJSON.message : err.responseText
                })
            })
        }



        function edit(data) {


            $('#edit_id').val(data.id)
            $('#edit_product').val(data.product_name)
            $('#edit_price').val(data.price)
            $('#edit_active').val(data.active)

            $('#editOutletModal').modal('show')
            resetMapEdit(data.latitude, data.longitude)

        }

        function update() {
            event.preventDefault()

            const data = $(event.target).serializeArray()

            $.ajax({
                url: '/master/outlet/{{ $outlet->id }}/updateproduct',
                method: 'POST',
                data: data,
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                beforeSend: () => $('.preloader').show(),
                complete: () => $('.preloader').fadeOut(),
                success: data => {
                    Swal.fire({
                        icon: 'success',
                        text: 'Data saved!!'
                    }).then(_ => {
                        location.reload()
                    })
                },
                error: err => Swal.fire({
                    icon: 'error',
                    html: err['responseJSON'] ? err.responseJSON.message : err.responseText
                })
            })
        }

    </script>
@endsection
