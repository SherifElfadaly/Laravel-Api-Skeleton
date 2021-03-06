<?php

namespace App\Modules\Roles\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRole extends FormRequest
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
            'name' => $requiredOrNullable . '|string|max:100|unique:roles,name,' . $this->route('id')
        ];
    }
}
