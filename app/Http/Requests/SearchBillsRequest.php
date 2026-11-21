<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchBillsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => 'nullable|string|max:300',
            'bill_type_id' => 'nullable|integer|max:11',
            'house_category_id' => 'nullable|integer|max:1',
            'bill_stage_id' => 'nullable|integer|max:11',
            'parliamentary_term_id' => 'nullable|integer|max:11',
            'parliamentary_session_id' => 'nullable|integer|max:11',
            'sponsor_id' => 'nullable|integer|max:11',
            'sponsorship_type_id' => 'nullable|integer|max:11',
            'paginate' => 'nullable|integer|min:2|max:2',
            'page' => 'nullable|integer|min:1|max:1',
        ];
    }
}
