@php
    $title = 'Permintaan Barang'
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
                columns: [
                    { dataField: 'id' },
                    { dataField: 'item_name', caption: 'Barang' },
                    { dataField: 'qty', caption: 'Qty' },
                    { dataField: 'outlet_name', caption: 'Outlet' },
                    { dataField: 'status', caption: 'Status' },
                    { dataField: 'created_at', caption: 'Tanggal Permintaan', dataType: 'datetime', format: 'yyyy/MM/dd HH:mm' },
                    { dataField: 'request_name', caption: 'Diminta Oleh' },
                    {
                        caption: 'Action',
                        cellTemplate: function (container, options) {
                            const approveButton = $('<button>').addClass('btn btn-primary btn-sm rounded-pill me-2').html(`<i class="fas fa-check"></i> Terima`).on('click', function() {
                                approve(options.data.id, 'APPROVED')
                            })
                            const cancelButton = $('<button>').addClass('btn btn-danger btn-sm rounded-pill me-2').html(`<i class="fas fa-times"></i> Tolak`).on('click', function() {
                                approve(options.data.id, 'CANCELED')
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
                text: `${status == 'CANCELED' ? 'Tolak' : 'Setujui'} permintaan barang`,
                showCancelButton: true,
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: '/item_requests/update',
                        method: 'POST',
                        data: { id, status },
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        beforeSend: () => $('.preloader').show(),
                        complete: () => $('.preloader').fadeOut(),
                        success: data => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Permintaan Barang',
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
