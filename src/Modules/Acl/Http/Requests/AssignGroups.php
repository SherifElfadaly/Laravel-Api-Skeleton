<?php

namespace App\Modules\Acl\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignGroups extends FormRequest
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
            'group_ids' => 'required|exists:groups,id',
            'user_id'   => 'required|exists:users,id'
        ];
    }
}
