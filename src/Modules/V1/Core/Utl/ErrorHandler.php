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
        $error = ['status' => 403, 'message' => 'Login token expired'];
        abort($error['status'], $error['message']);
    }

     public function noPermissions()
    {
        $error = ['status' => 403, 'message' => 'No permissions'];
        abort($error['status'], $error['message']);
    }

    public function loginFailed()
    {
        $error = ['status' => 400, 'message' => 'Wrong mail or password'];
        abort($error['status'], $error['message']);
    }

    public function loginFailedSocial()
    {
        $error = ['status' => 400, 'message' => 'Wrong auth code or acces token'];
        abort($error['status'], $error['message']);
    }

    public function noSocialEmail()
    {
        $error = ['status' => 400, 'message' => 'Couldn\'t retrieve email'];
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
        $error = ['status' => 403, 'message' => 'You have been blocked'];
        abort($error['status'], $error['message']);
    }

    public function invalidResetToken()
    {
        $error = ['status' => 400, 'message' => 'Reset password token is invalid'];
        abort($error['status'], $error['message']);
    }

    public function invalidResetPassword()
    {
        $error = ['status' => 400, 'message' => 'Reset password is invalid'];
        abort($error['status'], $error['message']);
    }

    public function notFound($text)
    {
        $error = ['status' => 404, 'message' => 'The requested ' . $text . ' not found'];
        abort($error['status'], $error['message']);
    }

    public function generalError()
    {
        $error = ['status' => 400, 'message' => 'Something went wrong'];
        abort($error['status'], $error['message']);
    }
}