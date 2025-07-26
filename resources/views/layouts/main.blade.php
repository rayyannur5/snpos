<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SNPOS | {{ $title }}</title>

    @include('layouts.css')
    @yield('css')
</head>
<body>

@include('layouts.preloader')

<div class="wrapper">

    @include('layouts.sidebar')

    @include('layouts.panel')

    @include('layouts.js')

    @yield('script')

</div>
</body>
</html>
