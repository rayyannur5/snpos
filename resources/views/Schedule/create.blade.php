@php
    $title = 'Tambah Jadwal'
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
                    <a href="{{ url('/schedule') }}">Penjadwalan</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ $title }}</a>
                </li>
            </ul>

        </div>

    </div>
@endsection

@section('container')
    <div class="card" style="min-height: 60vh">
        <div class="card-header row">
            <div class="col-lg-6 col-12 mt-2">
                <div class="d-flex gap-2">
                    <input type="text" class="form-control" id="date-range" style="text-align: center; color: black;" readonly>
                    <select name="outlet" id="outlet" class="form-control">
                        <option value="" selected disabled>Pilih Outlet</option>
                        @foreach($outlets as $o)
                            <option value="{{ $o->id }}">{{ $o->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary" onclick="buat()">Buat</button>
                </div>
            </div>
            <div class="col-lg-6 col-12 mt-2 d-flex gap-2 justify-content-end">
                <button class="btn btn-success" id="btn-template" disabled onclick="templateExcel()"><i class="fa fa-download"></i> Template Excel</button>
                <button class="btn btn-success me-3" data-bs-toggle="modal" data-bs-target="#unggahModal"><i class="fa fa-upload"></i> Unggah Excel</button>
                <button class="btn btn-primary" id="btn-save" onclick="saveSchedule()" disabled><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
        <div class="card-body">
            <div id="dataGrid"></div>
        </div>
    </div>

    <div class="modal fade" id="unggahModal" tabindex="-1" aria-labelledby="unggahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form onsubmit="upload()">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="unggahModalLabel">Unggah Excel</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="file" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('script')
    <script>

        let startDate = moment()
        let endDate = moment().add(6, 'days')

        function onDateRangeSelected(start, end, label) {
            console.log(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'), label);
            startDate = start;
            endDate = end;
            $('#date-range').val(start.format('DD-MM-YYYY') + '  ~  ' + end.format('DD-MM-YYYY'));
        }

        $('#date-range').daterangepicker({
            startDate: startDate,
            endDate: endDate,
            autoUpdateInput: false,
            ranges: {
                'Hari ini': [moment(), moment()],
                'Besok': [moment().add(1, 'days'), moment().add(1, 'days')],
                '7 Hari kedepan': [moment(), moment().add(6, 'days')],
                '30 Hari kedepan': [moment(), moment().add(29, 'days')],
                'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
                'Bulan depan': [
                    moment().add(1, 'month').startOf('month'),
                    moment().add(1, 'month').endOf('month')
                ]
            }

        }, onDateRangeSelected)

        onDateRangeSelected(startDate, endDate)

        function buat() {

            const outlet = $('#outlet').val()

            if(outlet == '' || outlet == null) {
                Swal.fire({
                    icon: 'warning',
                    text: 'Pilih outlet terlebih dahulu',
                    showConfirmButton: false
                })
                return
            }

            const start = startDate.format('YYYY-MM-DD')
            const end = endDate.format('YYYY-MM-DD')

            const employees = @json($employees);

            $.ajax({
                url: '/schedule/createCanvasSchedule',
                data: {start, end, outlet},
                beforeSend: () => $('.preloader').fadeIn(),
                complete: () => $('.preloader').fadeOut(),
                success: data => {

                    $('#btn-template').prop('disabled', false)
                    $('#btn-save').prop('disabled', false)

                    const columns = Object.keys(data.data[0]).map((item, index) => {
                        if(index == 0 || index == 1) {
                            return {dataField: item, allowEditing: false}
                        } else {
                            return {
                                dataField: item,
                                lookup: {
                                    dataSource: [
                                        { id: null, username: 'Pilih Karyawan' },
                                        ...employees
                                    ],
                                    valueExpr: "username",
                                    displayExpr: "username"
                                }
                            }
                        }
                    })

                    $('#dataGrid').dxDataGrid({
                        dataSource: data.data,
                        paging: false,
                        rowAlternationEnabled: true,
                        columnHidingEnabled: true,
                        columnAutoWidth: true,
                        export: {
                            enabled: true,
                            fileName: "template",
                        },
                        toolbar: {
                            visible: false
                        },
                        columns: columns,
                        editing: {
                            mode: "cell", // atau 'cell', 'popup'
                            allowUpdating: true
                        },
                    })
                },
                error: err => Swal.fire({
                    icon: 'error',
                    html: err['responseJSON'] ? err.responseJSON.message : err.responseText
                })
            })
        }

        function templateExcel() {
            $('#dataGrid').dxDataGrid('instance').exportToExcel(false);
        }

        function upload() {
            event.preventDefault()

            const data = new FormData(event.target)

            $.ajax({
                url: '/schedule/importSchedule',
                method: 'POST',
                data: data,
                contentType: false, // Harus false untuk FormData
                processData: false, // Harus false agar data tidak diprose
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                beforeSend: () => $('.preloader').show(),
                complete: () => $('.preloader').fadeOut(),
                success: data => {
                    Swal.fire({
                        icon: 'success',
                        text: 'Data Saved!!'
                    }).then(_ => {

                        const employees = @json($employees);

                        $('#btn-template').prop('disabled', false)
                        $('#btn-save').prop('disabled', false)


                        const columns = Object.keys(data.data[0]).map((item, index) => {
                            if(index == 0 || index == 1) {
                                return {dataField: item, allowEditing: false}
                            } else {
                                return {
                                    dataField: item,
                                    lookup: {
                                        dataSource: [
                                            { id: null, username: "Pilih Karyawan" },
                                            ...employees
                                        ],
                                        valueExpr: "username",
                                        displayExpr: "username"
                                    }
                                }
                            }
                        })

                        $('#dataGrid').dxDataGrid({
                            dataSource: data.data,
                            paging: false,
                            rowAlternationEnabled: true,
                            columnHidingEnabled: true,
                            columnAutoWidth: true,
                            export: {
                                enabled: true,
                                fileName: "template",
                            },
                            toolbar: {
                                visible: false
                            },
                            columns: columns,
                            editing: {
                                mode: "cell", // atau 'cell', 'popup'
                                allowUpdating: true
                            },
                        })

                    })
                },
                error: err => Swal.fire({
                    icon: 'error',
                    html: err['responseJSON'] ? err.responseJSON.message : err.responseText
                })
            })

        }

        function saveSchedule() {
            const rows = $('#dataGrid').dxDataGrid("instance").getDataSource().items()


            $.ajax({
                url: '/schedule/saveSchedule',
                method: 'POST',
                data: { rows },
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
    </script>
@endsection



