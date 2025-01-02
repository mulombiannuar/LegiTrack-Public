@extends('layouts.main')
@push('styles')
    <style>
        .ad-listing-title {
            font-size: 1.2em;
        }
    </style>
@endpush
@section('content')
    <section class="hero-area bg-1 text-center overly">
        <!-- Container Start -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Header Content -->
                    <div class="content-block">
                        <h1>Track Bills, Simplified</h1>
                        <p>Empowering Kenyans to stay informed and engaged. Track parliamentary bills with ease and
                            transparency – follow the progress of proposed laws, understand key issues, and participate in
                            the democratic process. Stay up-to-date and make your voice heard in shaping the future of Kenya
                        </p>
                    </div>
                    <!-- Advance Search -->
                    <div class="advance-search">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-12 col-md-12 align-content-center">
                                    <form method="get" action="{{ route('home') }}">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-xl-4 col-lg-3 col-md-6">
                                                <input type="text" name="search" class="form-control my-2 my-lg-1"
                                                    id="search" placeholder="Enter Bill Title or Subject"
                                                    autocomplete="on" required>
                                            </div>
                                            <div class="form-group col-xl-4 col-lg-3 col-md-6">
                                                <select name="house_category_id" id="house_category_id"
                                                    class="w-100 form-control mt-lg-1 mt-md-2">
                                                    <option class="mb-1" value="">Select Originating House</option>
                                                    <option value="1">National Assembly</option>
                                                    <option value="0">Senate</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-xl-4 col-lg-3 col-md-6"
                                                id="parliamentary_term_block">
                                                <select id="parliamentary_term_id" name="parliamentary_term_id"
                                                    class="w-100 form-control mt-lg-1 mt-md-2">
                                                    <option class="mb-1" value="">Select House First</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-xl-4 col-lg-3 col-md-6"
                                                id="parliamentary_session_block">
                                                <select name="parliamentary_session_id" id="parliamentary_session_id"
                                                    class="w-100 form-control mt-lg-1 mt-md-2">
                                                    <option class="mb-1" value="">Select Parliamentary Session
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group col-xl-4 col-lg-3 col-md-6">
                                                <select name="bill_type_id" id="bill_type_id"
                                                    class="w-100 form-control mt-lg-1 mt-md-2">
                                                    <option class="mb-1" value="">Select Bill Type </option>
                                                    @foreach ($bill_types as $bill_type)
                                                        @if ($bill_type['count'] > 0)
                                                            <option value="{{ $bill_type['id'] }}">
                                                                {{ ucwords($bill_type['name']) }}
                                                                ({{ $bill_type['count'] }})
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-xl-4 col-lg-3 col-md-6">
                                                <select name="bill_stage_id" id="bill_stage_id"
                                                    class="w-100 form-control mt-lg-1 mt-md-2">
                                                    <option class="mb-1" value="">
                                                        Select Bill Stage </option>
                                                    @foreach ($bill_stages as $bill_stage)
                                                        <option value="{{ $bill_stage['id'] }}">
                                                            {{ ucwords($bill_stage['name']) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-xl-4 col-lg-3 col-md-6">
                                                <select name="sponsorship_type_id" id="sponsorship_type_id"
                                                    class="w-100 form-control mt-lg-1 mt-md-2">
                                                    <option class="mb-1" value="">
                                                        Select Sponsorship Type </option>
                                                    @foreach ($sponsorship_types as $sponsorship_type)
                                                        @if ($sponsorship_type['count'] > 0)
                                                            <option value="{{ $sponsorship_type['id'] }}">
                                                                {{ ucwords($sponsorship_type['name']) }}
                                                                ({{ $sponsorship_type['count'] }})
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-xl-4 col-lg-3 col-md-6">
                                                <select name="sponsor_id" id="sponsor_id"
                                                    class="w-100 form-control mt-lg-1 mt-md-2">
                                                    <option class="mb-1" value="">
                                                        Select Sponsoring Member </option>
                                                    @foreach ($bill_sponsors as $bill_sponsor)
                                                        <option value="{{ $bill_sponsor['id'] }}">
                                                            {{ ucwords($bill_sponsor['profile']['full_name']) }}
                                                            ({{ $bill_sponsor['bills_count'] }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-xl-4 col-lg-3 col-md-6 align-self-center">
                                                <button type="submit" class="btn btn-success active w-100">Search Bills
                                                    Now</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container End -->
    </section>

    <section class="section-sm">
        <div class="container">
            <div class="row" id="search-header" style="display: none">
                <div class="col-md-12">
                    <div class="search-result bg-gray">
                        <h2 id="search-title"></h2>
                        <p id="search-desc"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    @include('app.pages.partials.category_sidebar')
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="category-search-filter" id="search-filter">
                        <div class="row">
                            <div class="col-md-6 text-center text-md-left">
                                <strong>Sort By</strong>
                                <select>
                                    <option value="0">Most Recent</option>
                                    <option value="1">Most Popular</option>
                                    <option value="2">Oldest Bill</option>
                                </select>
                            </div>
                            <div class="col-md-6 text-center text-md-right mt-2 mt-md-0">
                                <div class="view">
                                    <strong>Views</strong>
                                    <ul class="list-inline view-switcher">
                                        <li class="list-inline-item">
                                            <a href="#"><i class="fa fa-th-large"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#" class="text-info"><i class="fa fa-reorder"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('layouts.incls.loading')

                    <!-- bill listing block  -->
                    <div id="bill-listing-block"></div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            fetchBills();

            $(document).on('click', '.pagination-link', function(e) {
                e.preventDefault();

                const url = $(this).attr('href');

                if (url) {
                    const page = new URL(url).searchParams.get(
                        'page');
                    fetchBills(page);
                }
            });


            $('#house_category_id').change(function() {
                const house_category_id = $(this).val();
                const $parliamentaryTerms = $('#parliamentary_term_block');

                if (house_category_id !== '') {
                    $.ajax({
                        url: "{{ route('get-parliamentary-house-terms') }}",
                        type: 'POST',
                        data: {
                            house_category_id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $parliamentaryTerms.empty().html(response.html);
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr);
                        }
                    });
                }
            });

            $(document).on('change', '#parliamentary_term_id', function() {
                const parliamentary_term_id = $(this).val();
                const $parliamentarySessions = $('#parliamentary_session_block');

                if (parliamentary_term_id !== '') {
                    $.ajax({
                        url: "{{ route('get-parliamentary-term-sessions') }}",
                        type: 'POST',
                        data: {
                            parliamentary_term_id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $parliamentarySessions.empty().html(response.html);
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr);
                        }
                    });
                }
            });

        });

        function fetchBills(page = 1) {
            const remoteBaseUrl = "{{ config('app.remote_base_url') }}";
            const $billsListing = $('#bill-listing-block');
            const $loading = $('#loading');

            $.ajax({
                url: `${remoteBaseUrl}/api/get-bills`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    paginate: 10,
                    page: page,
                    with_html: true
                },
                beforeSend: function() {
                    $loading.show();
                    $billsListing.hide();
                },
                success: function(response) {
                    if (response.status && response.data.html) {
                        $billsListing.html(response.data.html);
                    } else {
                        console.error('Error: Invalid response format.');
                    }
                },
                complete: function() {
                    $loading.hide();
                    $billsListing.show();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching bills:', xhr.responseJSON?.errors || error);
                }
            });
        }

        function filterBills($filterType, $filterId) {
            const remoteBaseUrl = "{{ config('app.remote_base_url') }}";
            const $billsListing = $('#bill-listing-block');
            const $loading = $('#loading');

            $.ajax({
                url: `${remoteBaseUrl}/api/filter-bills`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    filter_type: $filterType,
                    filter_id: $filterId,
                },
                beforeSend: function() {
                    $loading.show();
                    $billsListing.hide();
                },
                success: function(response) {
                    if (response.status && response.data.html) {
                        $billsListing.html(response.data.html);
                        updateSearchHeader(response.data.search_title, response.data.search_desc);
                    } else {
                        console.error('Error: Invalid response format.');
                    }
                },
                complete: function() {
                    $loading.hide();
                    $billsListing.show();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching bills:', xhr.responseJSON?.errors || error);
                }
            });
        }

        function updateSearchHeader($title, $desc) {
            $('#search-title').text($title);
            $('#search-desc').text($desc);
            $('#search-header').show();
        }
    </script>
@endpush
