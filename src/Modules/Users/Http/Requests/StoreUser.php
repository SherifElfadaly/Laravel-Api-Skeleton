<?php

namespace App\Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
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
        $requiredOrNullable = request()->isMethod('PATCH') ? 'nullable' : 'required' . '';
        return [
            'name'     => 'nullable|string',
            'email'    => $requiredOrNullable . '|email|unique:users,email,' . $this->route('id'),
            'password' => 'nullable|min:6'
        ];
    }
}
