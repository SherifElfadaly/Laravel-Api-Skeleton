<?php

namespace App\Modules\Roles\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignPermissions extends FormRequest
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
            'permission_ids' => 'required|exists:permissions,id',
            'role_id'       => 'required|array|exists:roles,id'
        ];
    }
}
