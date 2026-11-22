@extends('layouts.main')

@section('content')
    <section class="section bg-gray">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="bill-glance text-center py-5">
                        @if ($bill_title !== null)
                            <h1 class="h4 font-weight-bold">You will no longer get updates</h1>
                            <p class="mb-4">You have stopped following <strong>{{ ucwords($bill_title) }}</strong>. You can follow it again from its page at any time.</p>
                        @else
                            <h1 class="h4 font-weight-bold">This link has already been used</h1>
                            <p class="mb-4">You are not following a Bill with this link any more.</p>
                        @endif
                        <a href="{{ route('search') }}" class="btn btn-main">Browse Bills</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
