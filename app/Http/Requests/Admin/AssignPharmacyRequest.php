<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AssignPharmacyRequest extends FormRequest
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
            'date_id' => 'required|numeric|exists:dates,id',
            'pharmacy_id' => 'required|array',
            'pharmacy_id.*' => 'numeric|exists:pharmacies,id',
            'time_from' => 'required|string',
            'time_to' => 'required|string',
        ];
    }
}
