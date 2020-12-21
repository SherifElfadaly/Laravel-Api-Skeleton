<?php

namespace App\Modules\PushNotificationDevices\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePushNotificationDevice extends FormRequest
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
            'device_token' => $requiredOrNullable . '|string|max:255',
            'user_id'      => $requiredOrNullable . '|exists:users,id'
        ];
    }
}
