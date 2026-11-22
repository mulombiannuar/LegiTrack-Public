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
            'q' => 'nullable|string|max:200',
            'search' => 'nullable|string|max:200',                 // older links and the home page search
            'house' => 'nullable|integer|min:1',
            'house_category_id' => 'nullable|integer|min:1',       // older links
            'status' => 'nullable|string|in:before_parliament,passed,became_law,did_not_proceed',
            'category' => 'nullable|string|in:ordinary,money,county,constitutional',
            'open' => 'nullable|boolean',
            'sort' => 'nullable|string|in:recent,oldest,title',
            'page' => 'nullable|integer|min:1|max:10000',
        ];
    }
}
