<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Flexy Free Bootstrap Admin Template by WrapPixel</title>
    @include('layouts.css')
</head>

<body>

@include('layouts.preloader')
<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed">
    <div
        class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3">
                    <div class="card mb-0">
                        <div class="card-body">
                            <a href="{{ url('/') }}" class="d-flex justify-content-center p-3">
                                <img src="{{ asset('assets/img/kaiadmin/logo_dark.svg') }}" style="width: 50%" alt="">
                            </a>
                            <form id="login" onsubmit="login()">
                                <div class="mb-3">
                                    <label for="input-username" class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username" id="input-username" aria-describedby="emailHelp" required>
                                </div>
                                <div class="mb-4">
                                    <label for="exampleInputPassword1" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="exampleInputPassword1" required>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                                        <label class="form-check-label text-dark" for="flexCheckChecked">
                                            Remeber this Device
                                        </label>
                                    </div>
                                    <a class="text-primary fw-bold" href="./index.html">Forgot Password ?</a>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Sign In</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.js')
<script>

    function login() {
        event.preventDefault()

        const data = $('#login').serializeArray()

        $.ajax({
            url: '/login',
            method: 'POST',
            data: data,
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            beforeSend: () => $('.preloader').show(),
            complete: () => $('.preloader').fadeOut(),
            success: data => {
                location.replace(data.data.url)
            },
            error: err => Swal.fire({
                icon: 'error',
                html: err['responseJSON'] ? err.responseJSON.message : err.responseText
            })
        })

    }
</script>

</body>

</html>
