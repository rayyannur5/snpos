@php
    $title = 'Modules'
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
                    <a href="#">User & Roles</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ $title }}</a>
                </li>
            </ul>

        </div>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fas fa-plus"></i> Add Module</button>
    </div>
@endsection

@section('container')
    <div class="card" style="min-height: 60vh">
        <div class="card-body">
            <div id="dataGrid"></div>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form onsubmit="add()">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addModalLabel">New Module</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="" class="form-label">Name</label>
                            <input type="text" name="name" id="add_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Icon</label>
                            <select name="icon" id="add_icon">
                                <option value="" selected disabled>Select Icon</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Parent</label>
                            <select name="parent" id="add_parent">
                                <option value="" selected disabled>Select parent</option>
                                @foreach($data as $d)
                                    <option value="{{ $d->id }}">{{ $d->name }} {{ $d->path != '' ? "($d->path)" : '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Path</label>
                            <input type="text" name="path" id="add_path" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Status</label>
                            <select name="status" id="add_status" class="form-select form-select" style="height: inherit !important; padding: 0.6rem 1rem">
                                <option value="A">Active</option>
                                <option value="D">Development</option>
                                <option value="N">Non Active</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Access to</label>
                            <select name="access[]" id="add_access" multiple>
                                <option value="" selected disabled>Select role</option>
                                @foreach($levels as $l)
                                    <option value="{{ $l->id }}">{{ $l->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
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
                        <h1 class="modal-title fs-5" id="editModalLabel">Edit Module</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label for="" class="form-label">Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Icon</label>
                            <select name="icon" id="edit_icon">
                                <option value="" selected disabled>Select Icon</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Parent</label>
                            <select name="parent" id="edit_parent">
                                <option value="" selected disabled>Select parent</option>
                                @foreach($data as $d)
                                    <option value="{{ $d->id }}">{{ $d->name }} {{ $d->path != '' ? "($d->path)" : '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Path</label>
                            <input type="text" name="path" id="edit_path" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Status</label>
                            <select name="status" id="edit_status" class="form-select form-select" style="height: inherit !important; padding: 0.6rem 1rem">
                                <option value="A">Active</option>
                                <option value="D">Development</option>
                                <option value="N">Non Active</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Access to</label>
                            <select name="access[]" id="edit_access" multiple>
                                <option value="" selected disabled>Select role</option>
                                @foreach($levels as $l)
                                    <option value="{{ $l->id }}">{{ $l->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('script')

    <script>

        $(document).ready(function() {

            fetch('/assets/css/fonts.min.css')
                .then(res => res.text())
                .then(cssText => {
                    const regex = /\.(fa|icon)-([a-z0-9-]+)\s*[:{]/gi;
                    const iconData = [];
                    let match;

                    while ((match = regex.exec(cssText)) !== null) {
                        const css = match[1] + '-' + match[2];
                        const value = match[1] === 'fa' ? `fas ${css}` : css;
                        iconData.push({ value: value, text: css, class: value });
                    }

                    // Inisialisasi Selectize dengan render custom
                    $('#add_icon').selectize({
                        options: iconData,
                        valueField: 'value',
                        labelField: 'text',
                        searchField: 'text',
                        render: {
                            option: function(item, escape) {
                                return `<div class="d-flex justify-content-between"> <span>${escape(item.text)}</span> <i class="${item.class}"></i></div>`;
                            },
                            item: function(item, escape) {
                                return `<div class="d-flex justify-content-between"> <span>${escape(item.text)}</span> <i class="${item.class}"></i></div>`;
                            }
                        }
                    });

                    $('#edit_icon').selectize({
                        options: iconData,
                        valueField: 'value',
                        labelField: 'text',
                        searchField: 'text',
                        render: {
                            option: function(item, escape) {
                                return `<div class="d-flex justify-content-between"> <span>${escape(item.text)}</span> <i class="${item.class}"></i></div>`;
                            },
                            item: function(item, escape) {
                                return `<div class="d-flex justify-content-between"> <span>${escape(item.text)}</span> <i class="${item.class}"></i></div>`;
                            }
                        }
                    });
                });

            $('#add_parent').selectize()
            $('#edit_parent').selectize()
            $('#add_access').selectize()
            $('#edit_access').selectize()

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
                    {dataField: 'name'},
                    {dataField: 'parent'},
                    {dataField: 'path'},
                    {dataField: 'access'},
                    {
                        dataField: 'status',
                        cellTemplate: function (container, options) {
                            if(options.value === 'D') {
                                $(container).html(`<span class="px-2 py-1 rounded-pill bg-warning-subtle">Development</span>`)
                            } else if(options.value === 'A') {
                                $(container).html(`<span class="px-2 py-1 rounded-pill bg-success-subtle">Active</span>`)
                            } else if (options.value === 'N') {
                                $(container).html(`<span class="px-2 py-1 rounded-pill bg-danger-subtle">Non Active</span>`)
                            }
                        }
                    },
                    {dataField: 'created_at'},
                    {dataField: 'updated_at'},
                    {
                        caption: 'Action',
                        cellTemplate: function(container, options) {

                            const editButton = $('<button>').addClass('btn btn-primary btn-sm rounded-pill').html(`<i class="icon-pencil"></i>`).on('click', function() {
                                edit(options.data)
                            })
                            $(container).append(editButton)

                        }
                    }
                ]
            })
        })

        function add() {
            event.preventDefault()
            const data = $(event.target).serializeArray()

            $.ajax({
                url: '/user&roles/modules',
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

            if(data.access_id) {
                const list_access = data.access_id.split(',')
                console.log(list_access)
                $('#edit_access')[0].selectize.setValue(list_access)
            }

            $('#edit_id').val(data.id)
            $('#edit_name').val(data.name)
            $('#edit_icon')[0].selectize.setValue(data.icon)
            $('#edit_parent')[0].selectize.setValue(data.parent_id)
            $('#edit_path').val(data.path)
            $('#edit_status').val(data.status)

            $('#editModal').modal('show')
        }

        function update() {
            event.preventDefault()
            const data = $(event.target).serializeArray()

            $.ajax({
                url: '/user&roles/modules/update',
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


    </script>
@endsection
