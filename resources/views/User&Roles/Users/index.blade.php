@php
    $title = 'Users'
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

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTambahModal"><i class="fas fa-plus"></i> Add User</button>
    </div>
@endsection

@section('container')
    <div class="card" style="min-height: 60vh">
        <div class="card-body">
            <div id="dataGrid"></div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="addTambahModal" tabindex="-1" aria-labelledby="addTambahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form onsubmit="add()">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addTambahModalLabel">Add New User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Level (Role)</label>
                            <select name="level" id="" class="form-select form-select" style="height: inherit !important; padding: 0.6rem 1rem">
                                <option value="" selected disabled>Select level</option>
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
                        <h1 class="modal-title fs-5" id="editModalLabel">Edit User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label for="" class="form-label">Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Username</label>
                            <input type="text" name="username" id="edit_username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Level (Role)</label>
                            <select name="level" id="edit_level" class="form-select form-select" style="height: inherit !important; padding: 0.6rem 1rem">
                                <option value="" selected disabled>Select level</option>
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
            const data = @json($data);


            // const columns = data.length > 0 ? Object.keys(data[0]).map(item => ({dataField: item})) : []

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
                    {dataField: 'ID'},
                    {dataField: 'Name'},
                    {dataField: 'Username'},
                    {dataField: 'Email'},
                    {dataField: 'Level'},
                    {dataField: 'Created'},
                    {dataField: 'Updated'},
                    {
                        dataField: 'Active',
                        dataType: 'string',
                        cellTemplate: function (container, options) {
                            if(options.value === 1) {
                                $(container).html(`<div class="px-2 py-1 bg-success-subtle rounded-pill" onclick="setActive(${options.data.ID})" style="width: min-content; cursor: pointer">Active</div>`)
                            } else {
                                $(container).html(`<div class="px-2 bg-danger-subtle rounded-pill" onclick="setActive(${options.data.ID})" style="width: min-content; cursor: pointer">Non Active</div>`)
                            }
                        }
                    },
                    {
                        caption: 'Action',
                        cellTemplate: function (container, options) {
                            $(container).html(`
                                <div class="d-flex gap-2">
                                    <button class="btn btn-warning btn-sm rounded-pill" onclick="resetUser(${options.data.ID}, '${options.data.Name}')"><i class="icon-refresh"></i></button>
                                    <button class="btn btn-primary btn-sm rounded-pill" onclick="editUser(${options.data.ID}, '${options.data.Name}', '${options.data.Username}', '${options.data.Email}', '${options.data.IDLevel}')"><i class="icon-pencil"></i></button>
                                </div>
                            `)
                        }
                    }
                ]
            })
        })

        function add() {
            event.preventDefault()

            const data = $(event.target).serializeArray()

            $.ajax({
                url: '/userroles/users',
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

        function resetUser(id, name) {
            Swal.fire({
                icon: 'warning',
                html: `Reset Password <strong>${name} (${id})</strong>`,
                showCancelButton: true
            }).then(_ => {
                if(_.isConfirmed) {
                    $.ajax({
                        url: `/userroles/users/reset/${id}`,
                        method: 'POST',
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        beforeSend: () => $('.preloader').show(),
                        complete: () => $('.preloader').fadeOut(),
                        success: data => {
                            Swal.fire({
                                icon: 'success',
                                text: 'Data saved!!'
                            })
                        },
                        error: err => Swal.fire({
                            icon: 'error',
                            html: err['responseJSON'] ? err.responseJSON.message : err.responseText
                        })
                    })
                }
            })
        }

        function setActive(id) {
            $.ajax({
                url: `/userroles/users/active/${id}`,
                method: 'POST',
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

        function editUser(id, name, username, email, idlevel) {
            $('#edit_id').val(id)
            $('#edit_name').val(name)
            $('#edit_username').val(username)
            $('#edit_email').val(email)
            $('#edit_level').val(idlevel)

            $('#editModal').modal('show')

        }

        function update() {
            event.preventDefault()

            const data = $(event.target).serializeArray()

            $.ajax({
                url: '/userroles/users/update',
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
