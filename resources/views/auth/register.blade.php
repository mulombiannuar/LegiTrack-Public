@extends('layouts.auth')

@section('content')
    <form id="register-form" action="#" method="post">
        <fieldset class="p-4">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <input class="form-control mb-3" type="email" name="email" id="email"
                        placeholder="Enter your email address" autocomplete="off" autofocus required>
                </div>
                <div class="col-md-6 col-sm-12">
                    <input class="form-control mb-3" type="text" name="national_id_no" id="national_id_no"
                        placeholder="Enter your national ID number" autocomplete="off" required>
                </div>
                <div class="col-md-6 col-sm-12">
                    <input class="form-control mb-3" type="text" name="mobile_no" id="mobile_no"
                        placeholder="Enter your mobile number" autocomplete="off" required>
                </div>
                <div class="col-md-6 col-sm-12">
                    <select class="form-control w-100 mb-3" name="county_id" id="county_id" required>
                        <option class="mb-1" value="">Select County</option>
                        <option value="1">Trans Nzoia</option>
                        <option value="2">Bungoma</option>
                    </select>
                </div>
                <div class="col-md-6 col-sm-12">
                    <select class="form-control w-100 mb-3" name="constituency_id" id="constituency_id" required>
                        <option class="mb-1" value="">Select Constituency</option>
                        <option value="1">Kiminini</option>
                        <option value="2">Saboti</option>
                    </select>
                </div>
                <div class="col-md-6 col-sm-12">
                    <select class="form-control w-100 mb-3" name="ward_id" id="ward_id" required>
                        <option class="mb-1" value="">Select Ward</option>
                        <option value="1">Sikhendu</option>
                        <option value="2">Sirende</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-success font-weight-bold mt-3" id="register-button">Register now</button>
        </fieldset>
    </form>
@endsection
