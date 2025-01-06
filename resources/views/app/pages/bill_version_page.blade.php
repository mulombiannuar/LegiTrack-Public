@extends('layouts.main')

@section('content')
    <div class="container">
        @if ($bill_version)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="pl-3 text-white">{{ $title }}</h2>
                        </div>
                        <div class="card-body">
                            <div id="flipbookContainer"></div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row p-lg-3 p-sm-5 p-4 justify-content-center">
                <div class="w-100 alert alert-warning font-weight-bold">
                    No bills version content found. Please check backlater
                </div>
            </div>
        @endif
    </div>
@endsection

@if ($bill_version)
    @push('styles')
        <style>
            .card {
                border: 1px solid #ccc;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                margin: 10px auto;
                background-color: #fff;
                margin-bottom: 50px;
            }

            .card-header {
                background-color: #28a745;
                color: #fff;
                padding: 10px;
                font-weight: bold;
            }
        </style>
        <link href="{{ asset('lib/css/min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('lib/css/themify-icons.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('scripts')
        <script src="{{ asset('lib/js/dflip.min.js') }}" type="text/javascript"></script>
        <script>
            jQuery(document).ready(function() {
                var pdf = "{{ 'data:application/pdf;base64,' . $bill_version['version_url'] }}";
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
