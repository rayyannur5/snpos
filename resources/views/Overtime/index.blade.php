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
                showBorders: true,
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
                    { dataField: 'id' },
                    { dataField: 'DibuatOleh' },
                    { dataField: 'Operator' },
                    { dataField: 'Shift' },
                    { dataField: 'Area' },
                    { dataField: 'Outlet' },
                    {
                        caption: 'Action',
                        cellTemplate: function (container, options) {
                            const button = $('<button>').addClass('btn btn-primary btn-sm rounded-pill').html(`<i class="fas fa-check"></i> Approve`).on('click', function() {
                                edit(options.data)
                            })

                            $(container).append(button)

                        }
                    }
                ]
            })
        })
    </script>
@endsection
