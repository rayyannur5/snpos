@php
    $title = 'Terima Setoran'
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
                <a href="#">Setoran</a>
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

    <!-- Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="detailModalLabel">Setoran</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="detail-body"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btn-modal-verifikasi">Verifikasi</button>
                </div>
            </div>
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
                    { dataField: 'Operator' },
                    { dataField: 'Tanggal', dataType: 'datetime', format: 'yyyy-MM-dd HH:mm' },
                    { dataField: 'Omset' },
                    { dataField: 'Outlet' },
                    {
                        caption: 'Action',
                        cellTemplate: function (container, options) {
                            const approveButton = $('<button>').addClass('btn btn-primary btn-sm rounded-pill me-2').html(`<i class="fas fa-check"></i> Verifikasi`).on('click', function() {
                                verify(options.data.id)
                            })

                            const detailButton = $('<button>').addClass('btn btn-dark btn-sm rounded-pill me-2').html(`<i class="fas fa-eye"></i> Detail`).on('click', function() {
                                detail(options.data.id)
                            })

                            $(container).append(approveButton).append(detailButton)

                        }
                    }
                ]
            })
        })

        function detail(id) {

            $.ajax({
                url: `/deposit/receipt/${id}`,
                beforeSend: () => $('.preloader').show(),
                complete: () => $('.preloader').fadeOut(),
                success: data => {
                    let html = `

                    <table style="width: 100%;">
                        <tr>
                            <td width="20%">Operator</td>
                            <td width="2%">:</td>
                            <td width="40%">${data.data.Operator}</td>
                            <td width="10%">Outlet</td>
                            <td width="2%">:</td>
                            <td width="40%">${data.data.Outlet}</td>
                        </tr>
                        <tr>
                            <td>Omset</td>
                            <td>:</td>
                            <td>${data.data.Omset}</td>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td>${data.data.Tanggal}</td>
                        </tr>
                        <tr>
                            <td>Total Transaksi</td>
                            <td>:</td>
                            <td>${data.data.TotalTransaksi}</td>
                        </tr>
                    </table>
                    <hr>


                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Produk</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${data.data.items.map(row => `
                                <tr>
                                    <td>${row.code_id}</td>
                                    <td>${row.product_name}</td>
                                    <td>${row.qty}</td>
                                    <td>${row.price}</td>
                                    <td>${row.total_amount}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">Total</td>
                                <td>${data.data.items.reduce((sum, item) => sum + parseInt(item.total_amount), 0)}</td>
                            </tr>
                        </tfoot>
                    </table>`

                    $('#detail-body').html(html)
                },
                error: err => Swal.fire({
                    icon: 'error',
                    html: err['responseJSON'] ? err.responseJSON.message : err.responseText
                })
            })

            $('#btn-modal-verifikasi').attr('onclick', `verify(${id})`)

            $('#detailModal').modal('show')

        }

        function verify(id) {
            Swal.fire({
                icon: 'warning',
                text: 'Verifikasi setoran ini',
                showCancelButton: true,
            }).then((result) => {
                if(result.isConfirmed) {

                    $.ajax({
                        url: `/deposit/receipt/${id}`,
                        method: 'POST',
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        beforeSend: () => $('.preloader').show(),
                        complete: () => $('.preloader').fadeOut(),
                        success: data => {
                            Swal.fire({
                                icon: 'success',
                                text: 'Berhasil memverifikasi',
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
