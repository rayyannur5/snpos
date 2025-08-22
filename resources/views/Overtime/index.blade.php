@php
    $title = 'Approve Lembur'
@endphp
@extends('layouts.main')

@section('header')
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
                <a href="#">Lembur</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{ $title }}</a>
            </li>
        </ul>
    </div>
@endsection

@section('container')
    <div class="card" style="min-height: 60vh">
        <div class="card-body">
            <div id="dataGridPending"></div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const pendingData = @json($pendings);

            console.log(pendingData);

            $('#dataGridPending').dxDataGrid({
                dataSource: pendingData,
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
                    { dataField: 'id' },
                    { dataField: 'DibuatOleh' },
                    { dataField: 'Operator' },
                    { dataField: 'Tanggal', dataType: 'date', format: 'yyyy/MM/dd' },
                    { dataField: 'Shift' },
                    { dataField: 'Area' },
                    { dataField: 'Outlet' },
                    {
                        caption: 'Action',
                        cellTemplate: function (container, options) {
                            const approveButton = $('<button>').addClass('btn btn-primary btn-sm rounded-pill me-2').html(`<i class="fas fa-check"></i> Approve`).on('click', function() {
                                approve(options.data)
                            })

                            const rejectButton = $('<button>').addClass('btn btn-danger btn-sm rounded-pill').html(`<i class="fas fa-times"></i> Reject`).on('click', function() {
                                reject(options.data)
                            })

                            $(container).append(approveButton).append(rejectButton)

                        }
                    }
                ]
            })
        })


        function approve(data) {
            Swal.fire({
                title: 'Approve',
                text: 'Setujui Lembur ini?',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: '/overtime/approval/approve',
                        method: 'POST',
                        data: data,
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        beforeSend: () => $('.preloader').show(),
                        complete: () => $('.preloader').fadeOut(),
                        success: data => {
                            Swal.fire({
                                icon: 'success',
                                text: 'Berhasil di setujui',
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
            })

        }

        function reject(data) {
            Swal.fire({
                title: 'Tolak',
                input: 'text',
                text: 'tolak Lembur ini?',
                inputPlaceholder: 'Alasan..',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Field ini wajib diisi!'
                    }
                },
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {

                    data.rejected_note = result.value

                    $.ajax({
                        url: '/overtime/approval/reject',
                        method: 'POST',
                        data: data,
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        beforeSend: () => $('.preloader').show(),
                        complete: () => $('.preloader').fadeOut(),
                        success: data => {
                            Swal.fire({
                                icon: 'success',
                                text: 'Berhasil di tolak',
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
            })
        }
    </script>
@endsection
