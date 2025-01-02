@extends('layouts.main')
@push('styles')
    <style>
        .ad-listing-title {
            font-size: 1.2em;
        }
    </style>
@endpush
@section('content')
    <section class="hero-area bg-1 text-center overly mb-100">
        <!-- Container Start -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @include('app.pages.partials.advance_search')
                </div>
            </div>
        </div>
        <!-- Container End -->
    </section>
    <section class="section-sm">
        <div class="container">
            @include('app.pages.partials.search_header')
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <!-- category search filter  -->
                    @include('app.pages.partials.category_search_filter')

                    <!-- Loading block  -->
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

        function fetchBills() {
            const remoteBaseUrl = "{{ config('app.remote_base_url') }}";
            const $billsListing = $('#bill-listing-block');
            const $loading = $('#loading');

            $.ajax({
                url: `${remoteBaseUrl}/api/get-bills`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: @json($search_query),
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
