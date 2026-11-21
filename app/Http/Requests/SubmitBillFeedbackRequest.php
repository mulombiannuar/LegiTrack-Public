<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitBillFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string|max:1000',
            'bill_support' => 'required|integer|max:10',
            'feedback_type' => 'required|integer|max:10',
            'bill_id' => 'required|integer|max:255',
        ];
    }
}
