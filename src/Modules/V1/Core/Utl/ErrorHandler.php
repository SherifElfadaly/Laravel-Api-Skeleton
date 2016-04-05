<?php namespace App\Modules\V1\Core\Utl;

class ErrorHandler
{
    public function unAuthorized()
    {
        $error = ['status' => 401, 'message' => 'Please login before any action'];
        abort($error['status'], $error['message']);
    }

    public function tokenExpired()
    {
        $error = ['status' => 401, 'message' => 'Login token expired'];
        abort($error['status'], $error['message']);
    }

     public function noPermissions()
    {
        $error = ['status' => 401, 'message' => 'No permissions'];
        abort($error['status'], $error['message']);
    }

    public function loginFailed()
    {
        $error = ['status' => 400, 'message' => 'Wrong mail or password'];
        abort($error['status'], $error['message']);
    }

    public function redisNotRunning()
    {
        $error = ['status' => 400, 'message' => 'Your redis notification server isn\'t running'];
        abort($error['status'], $error['message']);
    }

    public function dbQueryError()
    {
        $error = ['status' => 400, 'message' => 'Please check the given inputes'];
        abort($error['status'], $error['message']);
    }

    public function cannotCreateSetting()
    {
        $error = ['status' => 400, 'message' => 'Can\'t create setting'];
        abort($error['status'], $error['message']);
    }

    public function cannotUpdateSettingKey()
    {
        $error = ['status' => 400, 'message' => 'Can\'t update setting key'];
        abort($error['status'], $error['message']);
    }

    public function userIsBlocked()
    {
        $error = ['status' => 400, 'message' => 'You have been blocked'];
        abort($error['status'], $error['message']);
    }

    public function notFound($text)
    {
        $error = ['status' => 404, 'message' => 'The requested ' . $text . ' not found'];
        abort($error['status'], $error['message']);
    }
}