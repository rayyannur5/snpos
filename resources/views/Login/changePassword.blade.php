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
                            <a href="#" class="d-flex justify-content-center p-3">
                                <img src="{{ asset('assets/img/kaiadmin/logo_dark.svg') }}" style="width: 50%" alt="">
                            </a>
                            <form id="login" onsubmit="login()">
                                <div class="mb-3">
                                    <label for="input-username" class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username" id="input-username" aria-describedby="emailHelp" value="{{ auth()->user()->username }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Old Password</label>
                                    <input type="password" class="form-control" name="oldPassword" id="exampleInputPassword1" required>
                                </div>
                                <div class="mb-4">
                                    <label for="exampleInputPassword1" class="form-label">New Password</label>
                                    <input type="password" class="form-control" name="newPassword" id="exampleInputPassword1" required>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-8 mb-4 mt-3 rounded-2">Save</button>

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
            url: '/changePassword',
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
