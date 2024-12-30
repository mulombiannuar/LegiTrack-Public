<!DOCTYPE html>

<html lang="en">

<head>
    @include('layouts.incls.metas')
    @include('layouts.incls.styles')
</head>

<body class="body-wrapper">
    @include('layouts.incls.header')
    <section class="login py-5 border-top-1">
        <div class="container">
            <div class="row justify-content-center">
                <div
                    class="{{ request()->route()->uri === 'register' ? 'col-lg-8 col-md-8' : 'col-lg-5 col-md-8' }} align-item-center">
                    <div class="border">
                        <h3 class="bg-gray p-4">{{ ucwords($title) }}</h3>
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('layouts.incls.footer')
    @include('layouts.incls.scripts')

</body>

</html>
