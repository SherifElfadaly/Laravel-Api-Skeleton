<?php

namespace App\Modules\Acl\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Register extends FormRequest
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
            'name'     => 'nullable|string',
            'email'    => 'required|email|unique:users,email,'.$this->get('id'),
            'password' => 'required|min:6'
        ];
    }
}
