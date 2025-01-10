@extends('layouts.auth')

@section('content')
    <form id="reset-form" action="#" method="post">
        <fieldset class="p-4">
            <input class="form-control mb-3" type="password" name="password" id="password" placeholder="Enter new password"
                autofocus required>
            <input class="form-control mb-3" type="password" name="password_confirmation" id="password_confirmation"
                placeholder="Confirm new password" required>
            <button type="submit" id="reset-button" class="btn btn-success font-weight-bold mt-3 disable-button">Update
                Password</button>
        </fieldset>
    </form>
@endsection
