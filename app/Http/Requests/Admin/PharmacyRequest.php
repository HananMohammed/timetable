<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PharmacyRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'address'=> 'required|string|max:255',
            'website'=> 'required|url|max:255',
            'phone' => 'required|numeric|digits_between:5,16',
            'status' => 'required|in:0,1'
        ];
    }
}
