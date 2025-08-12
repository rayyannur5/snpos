@php
    $title = 'Outlet'
@endphp
@extends('layouts.main')

@section('css')
    <style>
        .leaflet-control-locate {
            background-color: white;
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 1px 4px rgba(0,0,0,0.3);
        }
    </style>
@endsection

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
                    <a href="#">Master</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ $title }}</a>
                </li>
            </ul>

        </div>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOutletModal" onclick="resetMap()"><i class="fas fa-plus"></i> Tambah Outlet</button>
    </div>
@endsection

@section('container')
    <div class="card" style="min-height: 60vh">
        <div class="card-body">
            <div id="dataGrid"></div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addOutletModal" tabindex="-1" aria-labelledby="addOutletModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <form onsubmit="add()">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addOutletModalLabel">Tambah Outlet</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-4 col-12">
                                <input type="hidden" id="add_latitude" name="latitude">
                                <input type="hidden" id="add_longitude" name="longitude">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama Outlet</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Area</label>
                                    <select id="add_area" name="area" class="form-select" required>
                                        <option value="" selected disabled>Pilih Area</option>
                                        @foreach($areas as $a)
                                            <option value="{{ $a->id }}">{{ $a->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Deskripsi</label>
                                    <textarea type="text" name="description" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-8 col-12">
                                <label for="" class="form-label">Lokasi</label>
                                <div id="map" style="width: 100%; height: 400px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editOutletModal" tabindex="-1" aria-labelledby="editOutletModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <form onsubmit="update()">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editOutletModalLabel">Tambah Outlet</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-4 col-12">
                                <input type="hidden" id="edit_id" name="id">
                                <input type="hidden" id="edit_latitude" name="latitude">
                                <input type="hidden" id="edit_longitude" name="longitude">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama Outlet</label>
                                    <input type="text" name="name" id="edit_name" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Area</label>
                                    <select id="edit_area" name="area" class="form-select" required>
                                        <option value="" selected disabled>Pilih Area</option>
                                        @foreach($areas as $a)
                                            <option value="{{ $a->id }}">{{ $a->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Deskripsi</label>
                                    <textarea type="text" id="edit_description" name="description" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Status</label>
                                    <select name="active" id="edit_active" class="form-select">
                                        <option value="" selected disabled>Pilih Status</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Non Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-8 col-12">
                                <label for="" class="form-label">Lokasi</label>
                                <div id="edit_map" style="width: 100%; height: 400px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@section('script')

    <script>


        $(document).ready(function() {

            $('#add_outlet').selectize()

            const data = @json($data);

            $('#dataGrid').dxDataGrid({
                dataSource: data,
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
                    {dataField: 'name', caption: 'Nama'},
                    {dataField: 'area_name', caption: 'Area'},
                    {dataField: 'description', caption: 'Deskripsi'},
                    {dataField: 'latitude', caption: 'Lat'},
                    {dataField: 'longitude', caption: 'Long'},
                    {dataField: 'created_at'},
                    {dataField: 'updated_at'},
                    {
                        dataField: 'active',
                        dataType: 'string',
                        cellTemplate: function (container, options) {
                            if(options.value == 1) {
                                $(container).html(`<div class="px-2 py-1 bg-success-subtle rounded-pill" style="width: min-content; cursor: pointer">Active</div>`)
                            } else {
                                $(container).html(`<div class="px-2 bg-danger-subtle rounded-pill" style="width: min-content; cursor: pointer">Non Active</div>`)
                            }
                        }
                    },
                    {
                        caption: 'Action',
                        cellTemplate: function (container, options) {
                            const button = $('<button>').addClass('btn btn-primary btn-sm rounded-pill').html(`<i class="fas fa-pen"></i>`).on('click', function() {
                                edit(options.data)
                            })

                            const detail = $(`<a href="/master/outlet/${options.data.id}" class="btn btn-dark btn-sm rounded-pill"><i class="fa fa-eye"></i> Detail</a>`)

                            const mainContainer = $('<div class="d-flex gap-2">').append(button).append(detail)

                            $(container).append(mainContainer)

                        }
                    }
                ]
            })


        })

        function add() {
            event.preventDefault()

            const check_lat = $('#add_latitude').val()

            if (check_lat == '' || check_lat == null) {
                Swal.fire({
                    icon: 'warning',
                    text: 'Peta belum di klik'
                });
                return
            }

            const data = $(event.target).serializeArray()

            $.ajax({
                url: '/master/outlet',
                method: 'POST',
                data: data,
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                beforeSend: () => $('.preloader').show(),
                complete: () => $('.preloader').fadeOut(),
                success: data => {
                    Swal.fire({
                        icon: 'success',
                        text: 'Data saved!!',
                        showConfirmButton: false
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



        function edit(data) {


            $('#edit_id').val(data.id)
            $('#edit_name').val(data.name)
            $('#edit_area').val(data.area_id)
            $('#edit_active').val(data.active)
            $('#edit_description').val(data.description)

            $('#editOutletModal').modal('show')
            resetMapEdit(data.latitude, data.longitude)

        }

        function update() {
            event.preventDefault()

            const data = $(event.target).serializeArray()

            $.ajax({
                url: '/master/outlet/update',
                method: 'POST',
                data: data,
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                beforeSend: () => $('.preloader').show(),
                complete: () => $('.preloader').fadeOut(),
                success: data => {
                    Swal.fire({
                        icon: 'success',
                        text: 'Data saved!!'
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

        function resetMap() {
            // MAP
            let marker;
            let map;

            const mapContainer = document.getElementById("map");
            if (mapContainer._leaflet_id) {
                mapContainer._leaflet_id = null;
            }

            // Fungsi update lat/lon dan marker
            function setMarker(lat, lng, text = "Lokasi dipilih") {

                $('#add_latitude').val(lat)
                $('#add_longitude').val(lng)

                const latlng = [lat, lng];

                if (marker) {
                    marker.setLatLng(latlng);
                } else {
                    marker = L.marker(latlng).addTo(map);
                }

                marker.bindPopup(text).openPopup();
            }

            // Ambil lokasi otomatis dari browser
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;



                    // Inisialisasi peta langsung di posisi pengguna
                    map = L.map('map').setView([lat, lng], 15);

                    // Tambahkan layer OSM
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(map);

                    setTimeout(() => {
                        map.invalidateSize();
                    }, 1000);

                    setMarker(lat, lng, "Lokasi otomatis (dari GPS)");

                    // Event klik di peta
                    map.on('click', function(e) {
                        const clickLat = e.latlng.lat.toFixed(6);
                        const clickLng = e.latlng.lng.toFixed(6);

                        setMarker(clickLat, clickLng);
                    });

                    L.Control.geocoder({
                        defaultMarkGeocode: true
                    })
                        .on('markgeocode', function(e) {
                            map.setView(e.geocode.center, 16);

                            setMarker(e.geocode.center.lat, e.geocode.center.lng, e.geocode.name)
                        })
                        .addTo(map);

                }, function(error) {
                    alert("Gagal mengambil lokasi: " + error.message);
                });
            } else {
                alert("Browser tidak mendukung geolocation.");
            }
        }

        function resetMapEdit(lat, lon) {
            // MAP
            let marker;
            let map;
            let currentLocationMarker;

            const mapContainer = document.getElementById("edit_map");
            if (mapContainer._leaflet_id) {
                mapContainer._leaflet_id = null;
            }

            // Fungsi update lat/lon dan marker
            function setMarker(lat, lng, text = "Lokasi dipilih") {

                $('#edit_latitude').val(lat)
                $('#edit_longitude').val(lng)

                const latlng = [lat, lng];

                if (marker) {
                    marker.setLatLng(latlng);
                } else {
                    marker = L.marker(latlng).addTo(map);
                }

                marker.bindPopup(text).openPopup();
            }

            map = L.map('edit_map').setView([lat, lon], 15);

            setMarker(lat, lon);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            setTimeout(() => {
                map.invalidateSize();
            }, 1000);

            map.on('click', function(e) {
                const clickLat = e.latlng.lat.toFixed(6);
                const clickLng = e.latlng.lng.toFixed(6);

                $('#edit_latitude').val(clickLat)
                $('#edit_longitude').val(clickLng)

                setMarker(clickLat, clickLng);
            });

            L.Control.geocoder({
                defaultMarkGeocode: true
            })
                .on('markgeocode', function(e) {
                    map.setView(e.geocode.center, 16);

                    setMarker(e.geocode.center.lat, e.geocode.center.lng, e.geocode.name)
                })
                .addTo(map);

            const locateButton = L.control({ position: 'topleft' });


            locateButton.onAdd = function(map) {
                const div = L.DomUtil.create('div', 'leaflet-control-locate');
                div.innerHTML = '📍 Lokasi Saya';
                div.onclick = function() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;

                            map.setView([lat, lng], 15);

                            setMarker(lat, lng, 'Lokasi Sekarang')

                        }, function(err) {
                            alert("Gagal mengambil lokasi: " + err.message);
                        });
                    } else {
                        alert("Browser tidak mendukung geolocation.");
                    }
                };
                return div;
            };

            locateButton.addTo(map);
        }
    </script>
@endsection


