<?php namespace App\Modules\Core\Utl;

class ErrorHandler
{
    public function unAuthorized()
    {
        return ['status' => 401, 'message' => 'Please login before any action'];
    }

    public function tokenExpired()
    {
        return ['status' => 401, 'message' => 'Login token expired'];
    }

     public function noPermissions()
    {
        return ['status' => 401, 'message' => 'No permissions'];
    }

    public function loginFailed()
    {
        return ['status' => 400, 'message' => 'Wrong mail or password'];
    }

    public function redisNotRunning()
    {
        return ['status' => 400, 'message' => 'Your redis notification server isn\'t running'];
    }

    public function dbQueryError()
    {
        return ['status' => 400, 'message' => 'Please check the given inputes'];
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