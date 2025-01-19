@extends('layouts.main')

@section('content')
    <section class="page-title">
        <!-- Container Start -->
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 text-center">
                    <!-- Title text -->
                    <h3>{{ $title }}</h3>
                </div>
            </div>
        </div>
        <!-- Container End -->
    </section>
    <section class="blog section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Loading block  -->
                    @include('layouts.incls.loading')

                    <!-- publication listing block  -->
                    <div id="publications-listing-block"></div>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar">
                        <!-- Search Widget -->
                        <div class="widget search p-0">
                            <div class="input-group">
                                <input type="text" class="form-control" id="expire" placeholder="Search...">
                                <span class="input-group-addon"><i class="fa fa-search px-3"></i></span>
                            </div>
                        </div>
                        <!-- Category Widget -->
                        <div class="widget category">
                            <!-- Widget Header -->
                            <h5 class="widget-header">Categories</h5>
                            <ul class="category-list">
                                <li><a href="#">Publications <span class="float-right">(2)</span></a></li>
                                <li><a href="#">News & Updates <span class="float-right">(5)</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            fetchPublications();

            $(document).on('click', '.pagination-link', function(e) {
                e.preventDefault();

                const url = $(this).attr('href');

                if (url) {
                    const page = new URL(url).searchParams.get(
                        'page');
                    fetchPublications(page);
                }
            });
        });

        function fetchPublications(page = 1) {
            const remoteBaseUrl = "{{ config('app.remote_base_url') }}";
            const $publicationsListing = $('#publications-listing-block');
            const $loading = $('#loading');

            $.ajax({
                url: `${remoteBaseUrl}/api/get-bill-publications`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    paginate: 5,
                    page: page,
                    with_html: true,
                    blog_listing: true,
                },
                beforeSend: function() {
                    $loading.show();
                    $publicationsListing.hide();
                },
                success: function(response) {
                    if (response.status && response.data.html) {
                        $publicationsListing.html(response.data.html);
                    } else {
                        console.error('Error: Invalid response format.');
                    }
                },
                complete: function() {
                    $loading.hide();
                    $publicationsListing.show();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching bills:', xhr.responseJSON?.errors || error);
                }
            });
        }
    </script>
@endpush
