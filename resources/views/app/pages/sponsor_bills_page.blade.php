@extends('layouts.main')
@push('styles')
    <style>
        .ad-listing-title {
            font-size: 1.2em;
        }
    </style>
@endpush
@section('content')
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
        });

        function fetchBills() {
            const remoteBaseUrl = "{{ config('app.remote_base_url') }}";
            const $billsListing = $('#bill-listing-block');
            const $searchHeader = $('#search-header');
            const $searchTitle = $('#search-title');
            const $searchDesc = $('#search-desc');
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
                    $searchHeader.hide();
                },
                success: function(response) {
                    console.log('Response:', response);
                    if (response.status && response.data.html) {
                        $searchDesc.text({{ $search_desc }});
                        $searchTitle.text({{ $search_title }});
                        $billsListing.html(response.data.html);
                    } else {
                        console.error('Error: Invalid response format.');
                    }
                },
                complete: function() {
                    $loading.hide();
                    $billsListing.show();
                    $searchHeader.show();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching bills:', xhr.responseJSON?.errors || error);
                }
            });
        }
    </script>
@endpush
