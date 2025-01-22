@extends('layouts.main')

@section('content')
    @include('app.pages.partials.page_title')
    <!-- contact us start-->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="contact-us-content p-4">
                        <h1 class="pt-3">Got Something to Share? Contact Us!</h1>
                        <p class="pt-3 pb-5">We'd love to hear from you! Whether you have a question, feedback, or just want
                            to connect, feel free to reach out to us.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('submit-contact') }}" method="post">
                        <input type="text" name="address" id="address" style="display:none;" autocomplete="off">
                        @csrf
                        <fieldset class="p-4">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12 py-1">
                                        <input type="text" name="name" id="name"
                                            placeholder="Enter your name here" class="form-control" autocomplete="off"
                                            autofocus required>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 py-1">
                                        <input type="email" name="email" id="email"
                                            placeholder="Enter your email here" class="form-control" autocomplete="off"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 py-1">
                                        <input type="text" name="subject" id="subject" autocomplete="off"
                                            placeholder="Enter subject here" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <textarea name="content" id="content" placeholder="Enter your message here" class="border w-100 p-3 py-1 mt-lg-4"
                                required></textarea>
                            <div class="btn-grounp">
                                <button type="submit" class="disable-button btn btn-success mt-2 float-right">SUBMIT
                                    MESSAGE</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- contact us end -->
@endsection
@push('styles')
    <style>
        #hidden_field {
            visibility: hidden;
            position: absolute;
            top: -9999px;
            left: -9999px;
        }
    </style>
@endpush
