@extends('layouts.auth')

@section('content')
    <form id="register-form" action="{{ route('register.store') }}" method="post">
        @csrf
        <input type="hidden" name="next" value="{{ $next }}">
        <fieldset class="p-4">
            <div class="row">
                @if (!config('app.iprs_enabled'))
                    <div class="col-md-6 col-sm-12">
                        <input class="form-control mb-3" type="text" name="first_name" id="first_name"
                            placeholder="Enter your first name" autocomplete="off" value="{{ old('first_name') }}" autofocus
                            required>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <input class="form-control mb-3" type="text" name="last_name" id="last_name"
                            placeholder="Enter your last name" autocomplete="off" value="{{ old('last_name') }}" required>
                    </div>
                @endif

                <div class="col-md-6 col-sm-12">
                    <input class="form-control mb-3" type="email" name="email" id="email"
                        placeholder="Enter your email address" autocomplete="off" value="{{ old('email') }}" autofocus
                        required>
                </div>
                <div class="col-md-6 col-sm-12">
                    <input class="form-control mb-3" type="text" name="national_id_no" id="national_id_no"
                        placeholder="Enter your national ID number" autocomplete="off" value="{{ old('national_id_no') }}"
                        required>
                </div>
                <div class="col-md-6 col-sm-12">
                    <input class="form-control mb-3" type="text" name="mobile_no" id="mobile_no"
                        placeholder="Enter your mobile number" autocomplete="off" value="{{ old('mobile_no') }}" required>
                </div>
                <div class="col-md-6 col-sm-12">
                    <select class="form-control w-100 mb-3" name="county_id" id="county_id" required>
                        <option class="mb-1" value="">Select County</option>
                        @foreach ($counties as $county)
                            <option value="{{ $county['id'] }}">{{ ucwords($county['name']) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 col-sm-12" id="sub_counties_block">
                    <select class="form-control w-100 mb-3" name="sub_county_id" id="sub_county_id" required>
                        <option class="mb-1" value="">Select County First</option>
                    </select>
                </div>
                <div class="col-md-6 col-sm-12" id="wards_block">
                    <select class="form-control w-100 mb-3" name="ward_id" id="ward_id" required>
                        <option class="mb-1" value="">Select Subcounty First</option>
                    </select>
                </div>
                <div class="col-md-6 col-sm-12">
                    <input class="form-control mb-3" type="password" name="password" id="password"
                        placeholder="Enter your password" autocomplete="off" value="{{ old('password') }}" required>
                </div>
                <div class="col-md-6 col-sm-12">
                    <input class="form-control mb-3" type="password" name="password_confirmation" id="password_confirmation"
                        placeholder="Confirm your password" autocomplete="off" value="{{ old('password') }}" required>
                </div>
            </div>
            <button type="submit" class="btn btn-success font-weight-bold mt-3 disable-button"
                id="register-button">Register now</button>
        </fieldset>
    </form>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            $('#county_id').change(function() {
                const county_id = $(this).val();
                const $subCountiesBlock = $('#sub_counties_block');

                if (county_id !== '') {
                    $.ajax({
                        url: "{{ route('get-sub-counties') }}",
                        type: 'POST',
                        data: {
                            county_id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $subCountiesBlock.empty().html(response.html);
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr);
                        }
                    });
                }
            });

            $(document).on('change', '#sub_county_id', function() {
                const sub_county_id = $(this).val();
                const $wardsBlock = $('#wards_block');

                if (sub_county_id !== '') {
                    $.ajax({
                        url: "{{ route('get-wards') }}",
                        type: 'POST',
                        data: {
                            sub_county_id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response);
                            $wardsBlock.empty().html(response.html);
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr);
                        }
                    });
                }
            });
        });
    </script>
@endpush
