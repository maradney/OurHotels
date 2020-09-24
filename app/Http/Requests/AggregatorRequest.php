<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AggregatorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'from_date' => 'required|date|date_format:Y-m-d',
            'to_date' => 'required|date|date_format:Y-m-d',
            'city' => 'required|max:3',
            'adults_number' => 'required|integer',
        ];
    }
}
