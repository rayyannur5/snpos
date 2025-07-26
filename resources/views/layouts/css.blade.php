<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
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
            urls: ["{{ asset('assets/css/fonts.min.css') }}"],
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
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/js/plugin/devextreme/css/dx.common.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/js/plugin/devextreme/css/dx.material.orange.light.compact.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/js/plugin/selectize/selectize.bootstrap5.css') }}" />



