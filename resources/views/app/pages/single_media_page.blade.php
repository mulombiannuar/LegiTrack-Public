@extends('layouts.main')

@section('content')
    <section class="blog single-blog section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if ($publication)
                        <article class="single-post">
                            <h2>{{ ucwords($publication['title']) }}</h2>
                            <ul class="list-inline">
                                <li class="list-inline-item">by <a href="#">Admin</a></li>
                                <li class="list-inline-item"> {{ format_date($publication['created_at'], 'd F Y h:i a') }}
                                </li>
                            </ul>

                            @if ($publication['category_id'] == 1)
                                <div class="mb-3" id="flipbookContainer"></div>
                            @else
                                <img class="mb-3" src="{{ $publication['media_file'] }}"
                                    title="{{ ucwords($publication['title']) }}" alt="{{ ucwords($publication['title']) }}">
                            @endif

                            {!! $publication['content'] !!}

                            <ul class="social-circle-icons list-inline">
                                <li class="list-inline-item text-center"><a class="fa fa-facebook"
                                        href="https://mulantech.co.ke/legitrack"></a></li>
                                <li class="list-inline-item text-center"><a class="fa fa-twitter"
                                        href="https://mulantech.co.ke/legitrack"></a></li>
                                <li class="list-inline-item text-center"><a class="fa fa-google-plus"
                                        href="https://mulantech.co.ke/legitrack"></a></li>
                                <li class="list-inline-item text-center"><a class="fa fa-pinterest-p"
                                        href="https://mulantech.co.ke/legitrack"></a></li>
                                <li class="list-inline-item text-center"><a class="fa fa-linkedin"
                                        href="https://mulantech.co.ke/legitrack"></a></li>
                            </ul>
                        </article>
                    @else
                        <div class="row p-lg-3 p-sm-5 p-4 justify-content-center">
                            <div class="w-100 alert alert-warning font-weight-bold">
                                No bill publication found. Please check backlater
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@if ($publication['category_id'] == 1)
    @push('styles')
        <link href="{{ asset('lib/css/min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('lib/css/themify-icons.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('scripts')
        <script src="{{ asset('lib/js/dflip.min.js') }}" type="text/javascript"></script>
        <script>
            jQuery(document).ready(function() {
                var pdf = "{{ $publication['media_file'] }}";
                var options = {
                    height: 700,
                    duration: 700,
                    backgroundColor: "#888",
                };
                var flipBook = $("#flipbookContainer").flipBook(pdf, options);
            });
        </script>
    @endpush
@endif
