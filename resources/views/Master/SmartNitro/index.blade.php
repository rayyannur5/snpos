@php
    $title = 'Smart Nitro'
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

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSmartNitroModal"><i class="fas fa-plus"></i> Tambah Smart Nitro</button>
    </div>
@endsection

@section('container')
    <div class="card" style="min-height: 60vh">
        <div class="card-body">
            <div id="dataGrid"></div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addSmartNitroModal" tabindex="-1" aria-labelledby="addSmartNitroModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form onsubmit="add()">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addSmartNitroModalLabel">Tambah Smart Nitro</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="" class="form-label">ID Smart Nitro</label>
                            <input type="text" name="id_smart_nitro" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Outlet</label>
                            <select name="outlet_id" id="add_outlet">
                                <option value="" selected disabled>Pilih Outlet</option>
                                @foreach($outlets as $o)
                                    <option value="{{ $o->id }}">{{ $o->name }}</option>
                                @endforeach
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

    <div class="modal fade" id="editOutletModal" tabindex="-1" aria-labelledby="editOutletModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form onsubmit="update()">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editOutletModalLabel">Tambah Smart Nitro</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label for="" class="form-label">ID Smart Nitro</label>
                            <input type="text" name="id_smart_nitro" id="edit_id_smart_nitro" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Outlet</label>
                            <select name="outlet_id" id="edit_outlet">
                                <option value="" selected disabled>Pilih Outlet</option>
                                @foreach($outlets as $o)
                                    <option value="{{ $o->id }}">{{ $o->name }}</option>
                                @endforeach
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

            $('#add_outlet').selectize()
            $('#edit_outlet').selectize()

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
                    {dataField: 'id'},
                    {dataField: 'outlet'},
                    {dataField: 'created_at'},
                    {dataField: 'updated_at'},
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
                url: '/master/smartnitro',
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
            $('#edit_id_smart_nitro').val(data.id)
            $('#edit_outlet').selectize()[0].selectize.setValue(data.outlet_id)

            $('#editOutletModal').modal('show')

        }

        function update() {
            event.preventDefault()

            const data = $(event.target).serializeArray()

            $.ajax({
                url: '/master/smartnitro/update',
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

