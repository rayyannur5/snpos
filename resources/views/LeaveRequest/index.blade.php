@php
    $title = 'Ijin Kerja'
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

            Fancybox.bind("[data-fancybox]");

            const pendingData = @json($data);

            $('#dataGridPending').dxDataGrid({
                dataSource: pendingData,
                columnHidingEnabled: true,
                columnAutoWidth: true,
                rowAlternationEnabled: true,
                filterRow: {
                    visible: true,
                    applyFilter: "auto"
                },
                headerFilter: {
                    visible: true,
                },
                paging: false,
                height: viewportHeight,
                searchPanel: {
                    visible: true
                },
                grouping: {
                    autoExpandAll: true
                },
                groupPanel: {
                    visible: true
                },
                summary: {
                    groupItems: [
                        {
                            summaryType: 'count'
                        }
                    ]
                },
                columns: [
                    { dataField: 'id' },
                    { dataField: 'user_name', caption: 'Nama' },
                    { dataField: 'category_name', caption: 'Kategori' },
                    { dataField: 'start_date', caption: 'Tanggal Mulai', dataType: 'date', format: 'yyyy/MM/dd' },
                    { dataField: 'end_date', caption: 'Tanggal Selesai', dataType: 'date', format: 'yyyy/MM/dd' },
                    { dataField: 'status', caption: 'Status' },
                    {
                        dataField: 'additional_file',
                        caption: 'File',
                        cellTemplate: function(container, options) {
                            if(options.value) {
                                if(options.value.endsWith('.pdf')) {
                                    $(container).html(`
                                        <a href="/storage/${options.value}" data-fancybox data-caption="${options.value}"><i class="fa fa-file-pdf"></i> Lihat PDF</a>
                                    `)
                                } else {
                                    $(container).html(`
                                        <a href="/storage/${options.value}" data-fancybox data-caption="${options.value}"><i class="fa fa-image"></i> Lihat Gambar</a>
                                    `)
                                }
                            }
                        }
                    },
                    {
                        caption: 'Action',
                        cellTemplate: function (container, options) {
                            const approveButton = $('<button>').addClass('btn btn-success btn-sm rounded-pill me-2').html(`<i class="fas fa-check"></i> Setuju`).on('click', function() {
                                approve(options.data.id, 'ACCEPTED')
                            })
                            const cancelButton = $('<button>').addClass('btn btn-danger btn-sm rounded-pill me-2').html(`<i class="fas fa-times"></i> Tolak`).on('click', function() {
                                approve(options.data.id, 'REJECTED')
                            })
                            $(container).append(approveButton).append(cancelButton)

                        }
                    }
                ]
            })
        })

        function approve(id, status) {
            Swal.fire({
                icon: 'warning',
                text: `${status == 'REJECTED' ? 'Tolak' : 'Setujui'} Permintaan Ijin ini`,
                showCancelButton: true,
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: '/leave/update',
                        method: 'POST',
                        data: { id, status },
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        beforeSend: () => $('.preloader').show(),
                        complete: () => $('.preloader').fadeOut(),
                        success: data => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Permintaan Ijin Kerja',
                            }).then(function () {
                                location.reload();
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
