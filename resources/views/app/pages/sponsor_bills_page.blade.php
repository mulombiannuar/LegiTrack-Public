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
            <div class="widget user text-center">
                <img width="300px;" class="rounded-circle img-fluid px-5" src="{{ $bill_sponsor['profile_image'] }}"
                    alt="{{ ucwords($bill_sponsor['full_name']) }}">
                <h4><a href="#">{{ ucwords($bill_sponsor['full_name']) }}</a></h4>
                @if ($user_positions)
                    <p class="member-time p-150">{{ $user_positions }}</p>
                @endif
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <!-- category search filter  -->

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
                        $searchDesc.text("{{ addslashes($search_desc) }}");
                        $searchTitle.text("{{ addslashes($search_title) }}");
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
