<?php

namespace App\Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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
            'id'       => 'required|exists:users,id',
            'name'     => 'nullable|string',
            'email'    => 'required|email|unique:users,email,'.$this->get('id'),
            'password' => 'nullable|min:6'
        ];
    }
}
