@extends('layouts.main')
@section('content')
    <section class="section bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-8 text-center mx-auto">
                    <div class="404-img">
                        <img src="{{ asset('images/503/503.png') }}" class="img-fluid" width="30%" alt="503">
                    </div>
                    <div class="404-content">
                        <h1 class="display-4 pt-1 pb-2">Service Temporarily Unavailable.</h1>
                        <p class="px-3 pb-2 text-dark">We are currently unable to retrieve the necessary information due to
                            a temporary issue with our service. Please try again later. Thank you for your patience!</p>
                        <a href="mailto:support@mulan.co.ke" class="btn btn-info">CONTACT US</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
