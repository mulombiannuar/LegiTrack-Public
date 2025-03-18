@extends('layouts.main')
@section('content')
    <section class="section-sm">
        <div class="container">
            <div class="row p-lg-3 p-sm-5 p-4 justify-content-center">
                <div class="w-100 alert alert-warning font-weight-bold">
                    No bills found for the specified user since the user does not exist.

                </div>
                <a href="{{ route('search') }}" class="btn btn-contact d-inline-block btn-success px-lg-5 my-1 px-md-3">
                    Click here to View all bills</a>
            </div>
        </div>
    </section>
@endsection
