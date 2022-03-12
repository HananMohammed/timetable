<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
        $pass = (request()->isMethod('post')) ? 'required|confirmed|min:6' : 'nullable|sometimes|confirmed|min:6';
        return [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email,'.$this->id,
            'status'=>'required|in:0,1',
            'role'=>'required|exists:roles,id',
            'password' => $pass,
        ];
    }
}
