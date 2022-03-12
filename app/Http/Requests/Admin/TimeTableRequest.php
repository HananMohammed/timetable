<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TimeTableRequest extends FormRequest
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
        $todayDate = date('Y-m-d');
        return [
            'user_id' => 'required|numeric|exists:users,id',
            'start_date' => 'required|date|date_format:Y-m-d|after:'.$todayDate,
            'end_date' => 'required|date|date_format:Y-m-d|after:start_date'
        ];
    }
}
