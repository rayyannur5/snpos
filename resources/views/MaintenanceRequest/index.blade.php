@php
    $title = 'Perbaikan'
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

    <!-- Modal -->
    <div class="modal fade" id="sharingModal" tabindex="-1" aria-labelledby="sharingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="sharingModalLabel">Bagikan Kerja</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-3">
                            <a href="" id="pic-placement-a" data-fancybox data-caption="" class="rounded border d-flex justify-content-center align-items-center h-100">
                                <img src="" id="pic-placement-img" style="max-width: 90%; max-height: 90%" alt="">
                            </a>
                        </div>
                        <div class="col-9">
                            <table class="w-100">
                                <tr>
                                    <td>ID</td>
                                    <td>:</td>
                                    <td id="data-id"></td>
                                </tr>
                                <tr>
                                    <td>Barang</td>
                                    <td>:</td>
                                    <td id="data-item"></td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                    <td>:</td>
                                    <td id="data-date"></td>
                                </tr>
                                <tr>
                                    <td>Diminta Oleh</td>
                                    <td>:</td>
                                    <td id="data-request-by"></td>
                                </tr>
                                <tr>
                                    <td>Outlet</td>
                                    <td>:</td>
                                    <td id="data-outlet"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <label for="" class="form-label">Bagikan Kerja</label>
                    <select name="" id="user" class="form-select">
                        <option value="" selected disabled>-- Pilih Operator --</option>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" onclick="submitShare()" class="btn btn-primary" id="btn-modal-verifikasi">Bagikan</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="showModalLabel">Perbaikan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-3">
                            <label for="" class="form-label">Foto Request</label>
                            <a id="pic-placement-show-request-a" href="" data-fancybox data-caption="" class="w-100 border rounded d-flex justify-content-center align-items-center overflow-hidden">
                                <img id="pic-placement-show-request-img" src="" style="max-height: 100%; max-width: 100%" alt="">
                            </a>
                        </div>
                        <div class="col-3">
                            <label for="" class="form-label">Foto Verifikasi</label>
                            <a id="pic-placement-show-approved-a" href="" data-fancybox data-caption="" class="w-100 border rounded d-flex justify-content-center align-items-center overflow-hidden">
                                <img id="pic-placement-show-approved-img" src="" style="max-height: 100%; max-width: 100%" alt="">
                            </a>
                        </div>
                        <div class="col-6">
                            <hr>
                            <table class="w-100">
                                <tr>
                                    <td>ID</td>
                                    <td>:</td>
                                    <td id="show-id"></td>
                                </tr>
                                <tr>
                                    <td>Barang</td>
                                    <td>:</td>
                                    <td id="show-item"></td>
                                </tr>
                                <tr>
                                    <td>Outlet</td>
                                    <td>:</td>
                                    <td id="show-outlet"></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>:</td>
                                    <td id="show-status"></td>
                                </tr>
                                <tr>
                                    <td>Diminta Oleh</td>
                                    <td>:</td>
                                    <td id="show-request-by"></td>
                                </tr>
                                <tr>
                                    <td>Dikerjakan Oleh</td>
                                    <td>:</td>
                                    <td id="show-user-to"></td>
                                </tr>
                                <tr>
                                    <td>Diverifikasi Oleh</td>
                                    <td>:</td>
                                    <td id="show-approved-by"></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Permintaan</td>
                                    <td>:</td>
                                    <td id="show-date-request"></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Dibagikan</td>
                                    <td>:</td>
                                    <td id="show-date-share"></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Dikerjakan</td>
                                    <td>:</td>
                                    <td id="show-date-start"></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Diverifikasi</td>
                                    <td>:</td>
                                    <td id="show-date-approve"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {

            Fancybox.bind("[data-fancybox]");

            const pendingData = @json($pendings);

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
                    { dataField: 'Barang' },
                    { dataField: 'Outlet' },
                    { dataField: 'Status' },
                    { dataField: 'TanggalPermintaan', dataType: 'datetime', format: 'yyyy/MM/dd HH:mm' },
                    { dataField: 'TanggalDibagikan', dataType: 'datetime', format: 'yyyy/MM/dd HH:mm' },
                    { dataField: 'TanggalDikerjakan', dataType: 'datetime', format: 'yyyy/MM/dd HH:mm' },
                    { dataField: 'TanggalVerifikasi', dataType: 'datetime', format: 'yyyy/MM/dd HH:mm' },
                    { dataField: 'DimintaOleh' },
                    {
                        caption: 'Action',
                        cellTemplate: function (container, options) {
                            const shareButton = $('<button>').addClass('btn btn-primary btn-sm rounded-pill me-2').html(`<i class="fas fa-arrow-right"></i> Bagikan Kerja`).on('click', function() {
                                share(options.data)
                            })
                            const detailButton = $('<button>').addClass('btn btn-dark btn-sm rounded-pill me-2').html(`<i class="fas fa-eye"></i> Detail`).on('click', function() {
                                show(options.data)
                            })
                            $(container).append(detailButton)
                            if(options.data.TanggalDibagikan == null) {
                                $(container).append(shareButton)
                            }


                        }
                    }
                ]
            })
        })

        function show(data){

            $('#pic-placement-show-request-a').attr('href', `/storage/${data.request_picture}`).attr('data-caption', data.request_picture)
            $('#pic-placement-show-request-img').attr('src', `/storage/${data.request_picture}`)

            $('#pic-placement-show-approved-a').attr('href', `/storage/${data.approved_picture}`).attr('data-caption', data.approved_picture)
            $('#pic-placement-show-approved-img').attr('src', `/storage/${data.approved_picture}`)

            $('#show-id').html(data.id)
            $('#show-item').html(data.Barang)
            $('#show-outlet').html(data.Outlet)
            $('#show-status').html(data.Status)
            $('#show-request-by').html(data.DimintaOleh)
            $('#show-user-to').html(data.DikerjakanOleh)
            $('#show-approved-by').html(data.DiverifikasiOleh)
            $('#show-date-request').html(data.TanggalPermintaan)
            $('#show-date-share').html(data.TanggalDibagikan)
            $('#show-date-start').html(data.TanggalDikerjakan)
            $('#show-date-approve').html(data.TanggalVerifikasi)

            $('#showModal').modal('show')
        }

        function share(data) {

            $('#pic-placement-a').attr('href', `/storage/${data.request_picture}`).attr('data-caption', data.request_picture)
            $('#pic-placement-img').attr('src', `/storage/${data.request_picture}`)
            $('#data-id').html(data.id)
            $('#data-item').html(data.Barang)
            $('#data-outlet').html(data.Outlet)
            $('#data-request-by').html(data.DimintaOleh)
            $('#data-date').html(data.TanggalPermintaan)

            $('#sharingModal').modal('show')
        }

        function submitShare() {
            const id = $('#data-id').html()
            const user = $('#user').val()

            $.ajax({
                url: '/maintenance/share',
                method: 'POST',
                data: { id, user },
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                beforeSend: () => $('.preloader').show(),
                complete: () => $('.preloader').fadeOut(),
                success: data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Berhasil bagikan kerja'
                    }).then((result) => {
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
