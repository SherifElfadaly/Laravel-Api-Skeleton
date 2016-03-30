<?php namespace App\Modules\Core;

class ErrorHandler
{
    public function unAuthorized()
    {
        return ['status' => 401, 'message' => 'Please login before any action'];
    }

    public function loginFailed()
    {
        return ['status' => 400, 'message' => 'Wrong mail or password'];
    }

    public function noPermissions()
    {
        return ['status' => 401, 'message' => 'No permissions'];
    }

    public function cannotCreateSetting()
    {
        return ['status' => 400, 'message' => 'Can\'t create setting'];
    }

    public function cannotUpdateSettingKey()
    {
        return ['status' => 400, 'message' => 'Can\'t update setting key'];
    }

    public function notFound($text)
    {
        return ['status' => 404, 'message' => 'The requested ' . $text . ' not found'];
    }
}