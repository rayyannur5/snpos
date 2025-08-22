@php
    $title = 'Penjadwalan'
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
                    <a href="#">{{ $title }}</a>
                </li>
            </ul>
        </div>

        <a href="/schedule/create" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Jadwal</a>
    </div>
@endsection

@section('container')
    <div class="card" style="min-height: 60vh">
        <div class="card-header">
            <input type="text" class="form-control" id="date-range" style="width: 250px; text-align: center; color: black;" readonly>
        </div>
        <div class="card-body">
            <div id="dataGrid"></div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function onDateRangeSelected(start, end, label) {
            console.log(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'), label);
            $('#date-range').val(start.format('DD-MM-YYYY') + '  ~  ' + end.format('DD-MM-YYYY'));

            $.ajax({
                url: '/schedule/getSchedule',
                data: {
                    start: start.format('YYYY-MM-DD'),
                    end: end.format('YYYY-MM-DD')
                },
                beforeSend: () => $('.preloader').fadeIn(),
                complete: () => $('.preloader').fadeOut(),
                success: data => {
                    $('#dataGrid').dxDataGrid({
                        dataSource: data.data,
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
                        export: {
                            enabled: true,
                            fileName: "Jadwal Operator",
                        },
                        headerFilter: {
                            visible: true,
                            applyFilter: "auto"
                        },
                        paging: false,
                        height: viewportHeight - 70,
                        summary: {
                            groupItems: [
                                {
                                    summaryType: 'count'
                                }
                            ]
                        },
                        columns: [
                            {dataField: 'date', dataType: 'date', format: 'yyyy/MM/dd'},
                            {dataField: 'outlet'},
                            {dataField: 'username'},
                            {dataField: 'shift'},
                        ]
                    })
                },
                error: err => Swal.fire({
                    icon: 'error',
                    html: err['responseJSON'] ? err.responseJSON.message : err.responseText
                })
            })

        }

        $('#date-range').daterangepicker({
            startDate: moment(),
            endDate: moment(),
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

        onDateRangeSelected(moment(), moment())
    </script>
@endsection



