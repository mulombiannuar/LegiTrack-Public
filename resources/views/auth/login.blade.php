@extends('layouts.auth')

@section('content')
    <form id="login-form" action="#" method="post">
        <fieldset class="p-4">
            <input class="form-control mb-3" type="email" name="email" id="email" placeholder="Enter your email address"
                autofocus required>
            <input class="form-control mb-3" type="password" name="password" id="password" placeholder="Enter your Password"
                required>
            <button type="submit" id="login-button" class="btn btn-success font-weight-bold mt-3">Log
                in now</button>
            <a class="mt-3 d-block text-success" href="{{ route('password.request') }}">Forgot Password?</a>
            <a class="mt-3 d-inline-block text-success" href="{{ route('register') }}">Register Now</a>
        </fieldset>
    </form>
@endsection
