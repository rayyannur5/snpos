@php
    $title = 'Shift'
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

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLevelModal"><i class="fas fa-plus"></i> Add Level</button>
    </div>
@endsection
