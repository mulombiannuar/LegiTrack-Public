@extends('layouts.main')

@section('content')
    @include('app.pages.partials.page_title')
    <section class="blog section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 product-review">
                    <!-- Loading block  -->
                    @include('layouts.incls.loading')

                    <!-- publication listing block  -->
                    <div id="downloads-listing-block"></div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            fetchDownloads();

            $(document).on('click', '.pagination-link', function(e) {
                e.preventDefault();

                const url = $(this).attr('href');

                if (url) {
                    const page = new URL(url).searchParams.get(
                        'page');
                    fetchDownloads(page);
                }
            });
        });

        function fetchDownloads(page = 1) {
            const remoteBaseUrl = "{{ config('app.remote_base_url') }}";
            const $downloadsListing = $('#downloads-listing-block');
            const $loading = $('#loading');

            $.ajax({
                url: `${remoteBaseUrl}/api/get-downloads`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    paginate: 10,
                    page: page,
                    with_html: true,
                },
                beforeSend: function() {
                    $loading.show();
                    $downloadsListing.hide();
                },
                success: function(response) {
                    // console.log(response)
                    if (response.status && response.data.html) {
                        $downloadsListing.html(response.data.html);
                    } else {
                        console.error('Error: Invalid response format.');
                    }
                },
                complete: function() {
                    $loading.hide();
                    $downloadsListing.show();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching bills:', xhr.responseJSON?.errors || error);
                }
            });
        }
    </script>
@endpush
