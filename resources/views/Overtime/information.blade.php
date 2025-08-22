@php
    $title = 'Informasi Lembur'
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


            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab" aria-controls="approved" aria-selected="true">Di Setujui</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#rejected" type="button" role="tab" aria-controls="rejected" aria-selected="true">Di Tolak</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="approved" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                    <div id="gridContainerAproved" class="mt-3"></div>
                </div>
                <div class="tab-pane" id="rejected" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                    <div id="gridContainerRejected" class="mt-3"></div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        const approved = @json($approved);
        const rejected = @json($rejected);

        $('#gridContainerAproved').dxDataGrid({
            dataSource: approved,
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
            height: viewportHeight - 50,
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
                { dataField: 'check_in_time', dataType: 'datetime', format: 'yyyy/MM/dd HH:mm' },
                { dataField: 'check_out_time', dataType: 'datetime', format: 'yyyy/MM/dd HH:mm' },
            ]
        })

        $('#gridContainerRejected').dxDataGrid({
            dataSource: rejected,
            height: 'auto',
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
            height: viewportHeight - 50,
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
            ]
        })

    </script>
@endsection
