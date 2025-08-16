{{--<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/webfontloader@1.6.28/webfontloader.min.js"></script>
<script>
    WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
            families: [
                "Font Awesome 5 Solid",
                "Font Awesome 5 Regular",
                "Font Awesome 5 Brands",
                "simple-line-icons",
            ],
            urls: ["https://cdn.jsdelivr.net/gh/rayyannur5/snpos_assets@master/web/css/fonts.min.css"],
        },
        active: function () {
            sessionStorage.fonts = true;
        },
    });
</script>


<style>
    #nprogress .bar {
        background: #f44336 !important; /* Ganti dengan kode warna yang Anda inginkan */
        height: 10px !important; /* Ganti tinggi garis */
    }

    /* Ganti warna bayangan di ujung garis (peg) */
    #nprogress .peg {
        box-shadow: 0 0 10px #f44336, 0 0 5px #f44336 !important;
    }

    /* Sembunyikan lingkaran/spinner (jika masih muncul) */
    #nprogress .spinner {
        display: none !important;
    }
</style>

<!-- CSS Files -->
{{--<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />--}}
{{--<link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}" />--}}
{{--<link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.css') }}" />--}}

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" />
{{--<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rayyannur5/snpos_assets@master/web/css/bootstrap.min.css" />--}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rayyannur5/snpos_assets@master/web/css/plugins.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rayyannur5/snpos_assets@master/web/css/kaiadmin.min.css" />

{{--<link rel="stylesheet" href="{{ asset('assets/js/plugin/devextreme/css/dx.common.css') }}" />--}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/devextreme@22.1.6/dist/css/dx.common.min.css" />
{{--<link rel="stylesheet" href="{{ asset('assets/js/plugin/devextreme/css/dx.material.orange.light.compact.css') }}" />--}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/devextreme@22.1.6/dist/css/dx.material.blue.light.compact.min.css" />
{{--<link rel="stylesheet" href="{{ asset('assets/js/plugin/selectize/selectize.bootstrap5.css') }}" />--}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@selectize/selectize@0.15.2/dist/css/selectize.bootstrap5.min.css" />
{{--<link rel="stylesheet" href="{{ asset('assets/js/plugin/clockpicker/jquery-clockpicker.min.css') }}" />--}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/clockpicker@0.0.7/dist/jquery-clockpicker.min.css" />


<!--   Core JS Files   -->
{{--<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
{{--<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
{{--<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/leaflet-control-geocoder@3.2.1/dist/Control.Geocoder.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/leaflet-control-geocoder@3.2.1/dist/Control.Geocoder.min.css" rel="stylesheet">


<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
