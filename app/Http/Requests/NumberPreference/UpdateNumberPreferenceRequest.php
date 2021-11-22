<?php

namespace App\Http\Requests\NumberPreference;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNumberPreferenceRequest extends FormRequest
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
            'number_id' => ['required', 'exists:numbers,id'],
            'name' => 'required|string|max:100',
            'value' => 'required|string|max:100',
        ];
    }
}
