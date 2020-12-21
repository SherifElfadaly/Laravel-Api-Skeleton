<?php

namespace App\Modules\OauthClients\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOauthClient extends FormRequest
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
            'name'     => $requiredOrNullable . '|max:255',
            'redirect' => $requiredOrNullable . '|url',
            'user_id'  => $requiredOrNullable . '|exists:users,id',
            'revoked'  => 'boolean'
        ];
    }
}
