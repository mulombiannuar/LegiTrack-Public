<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|string|max:255',
            'mobile_no' => 'required|string|max:13|min:10',
            'national_id_no' => 'required|string|max:20',
            'ward_id' => 'required|integer',
            'sub_county_id' => 'required|integer',
            'county_id' => 'required|integer',
            'password' => 'required|string|min:8|confirmed',
            'next' => 'nullable|string|max:255',
        ];
    }
}
