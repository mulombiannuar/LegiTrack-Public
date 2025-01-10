@extends('layouts.auth')

@section('content')
    <form id="reset-form" action="{{ route('password.request') }}" method="post">
        @csrf
        <fieldset class="p-4">
            <input class="form-control mb-3" type="email" name="email" id="email" placeholder="Enter your email address"
                autofocus required>
            <button type="submit" id="reset-button" class="btn btn-success font-weight-bold mt-3 disable-button">Reset
                Password</button>
        </fieldset>
    </form>
@endsection
