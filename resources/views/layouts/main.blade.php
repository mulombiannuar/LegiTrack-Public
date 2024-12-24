<!DOCTYPE html>

<html lang="en">

<head>
    @include('layouts.incls.metas')
    @include('layouts.incls.styles')
</head>

<body class="body-wrapper">
    @include('layouts.incls.header')
    @yield('content')
    @include('layouts.incls.footer')
    @include('layouts.incls.scripts')

</body>

</html>
