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
            'content' => 'required|string|max:20000',
            'clause_reference' => 'nullable|string|max:100',
            'submitter_type' => 'nullable|string|in:individual,organisation',
            'organisation_name' => 'nullable|required_if:submitter_type,organisation|string|max:200',
            'bill_support' => 'required|integer|in:0,1,2',
            'feedback_type' => 'required|integer|max:10',
            'bill_id' => 'required|integer|max:255',
        ];
    }
}
