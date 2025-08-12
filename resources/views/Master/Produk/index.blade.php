@php
    $title = 'Produk'
@endphp
@extends('layouts.main')

@section('header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="page-header">
            <h3 class="fw-bold mb-3">{{ $title }}</h3>
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
                    <a href="#">{{ $title }}</a>
                </li>
            </ul>

        </div>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal"><i class="fas fa-plus"></i> Tambah Produk</button>
    </div>
@endsection

@section('container')
    <div class="card" style="min-height: 60vh">
        <div class="card-body">
            <div id="dataGrid"></div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form onsubmit="add()">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addProductModalLabel">Tambah Produk</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="" class="form-label">Nama Produk</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="d-flex mb-3">
                            <label class="form-control" style="width: min-content">
                                <input type="checkbox" name="mandatory" checked class="form-check-input">
                            </label>
                            <span class="input-group-text flex-grow-1" id="basic-addon2">Wajib</span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Harga Default</label>
                            <input type="number" name="default_price" class="form-control" required>
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

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form onsubmit="update()">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel">Ubah Produk</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label for="" class="form-label">Nama Produk</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Harga Default</label>
                            <input type="number" id="edit_default_price" name="default_price" class="form-control" required>
                        </div>
                        <div class="d-flex mb-3">
                            <label class="form-control" style="width: min-content">
                                <input type="checkbox" id="edit_mandatory" name="mandatory" class="form-check-input">
                            </label>
                            <span class="input-group-text flex-grow-1" id="basic-addon2">Wajib</span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Status</label>
                            <select name="active" id="edit_active" class="form-select">
                                <option value="" selected disabled>Pilih Status</option>
                                <option value="1">Active</option>
                                <option value="0">Non Active</option>
                            </select>
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
            const data = @json($data);

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
                columns: [
                    {dataField: 'name', caption: 'Nama Produk'},
                    {dataField: 'default_price', caption: 'Harga Default'},
                    {dataField: 'mandatory', dataType: 'boolean', caption: 'Wajib Produk'},
                    {dataField: 'created_at'},
                    {dataField: 'updated_at'},
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
                url: '/master/products',
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
            console.log(data)
            $('#edit_id').val(data.id)
            $('#edit_name').val(data.name)
            $('#edit_active').val(data.active)
            $('#edit_default_price').val(data.default_price)
            $('#edit_mandatory').prop('checked', data.mandatory)

            $('#editModal').modal('show')

        }

        function update() {
            event.preventDefault()

            const data = $(event.target).serializeArray()

            $.ajax({
                url: '/master/products/update',
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

