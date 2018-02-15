<?php namespace App\Modules\V1\Core\Utl;

class ErrorHandler
{
    public function unAuthorized()
    {
        $error = ['status' => 401, 'message' => trans('errors.unAuthorized')];
        abort($error['status'], $error['message']);
    }

    public function invalidRefreshToken()
    {
        $error = ['status' => 401, 'message' => trans('errors.invalidRefreshToken')];
        abort($error['status'], $error['message']);
    }

     public function noPermissions()
    {
        $error = ['status' => 403, 'message' => trans('errors.noPermissions')];
        abort($error['status'], $error['message']);
    }

    public function loginFailed()
    {
        $error = ['status' => 400, 'message' => trans('errors.loginFailed')];
        abort($error['status'], $error['message']);
    }

    public function noSocialEmail()
    {
        $error = ['status' => 400, 'message' => trans('errors.noSocialEmail')];
        abort($error['status'], $error['message']);
    }

    public function userAlreadyRegistered()
    {
        $error = ['status' => 400, 'message' => trans('errors.userAlreadyRegistered')];
        abort($error['status'], $error['message']);
    }

    public function connectionError()
    {
        $error = ['status' => 400, 'message' => trans('errors.connectionError')];
        abort($error['status'], $error['message']);
    }

    public function redisNotRunning()
    {
        $error = ['status' => 400, 'message' => trans('errors.redisNotRunning')];
        abort($error['status'], $error['message']);
    }

    public function dbQueryError()
    {
        $error = ['status' => 400, 'message' => trans('errors.dbQueryError')];
        abort($error['status'], $error['message']);
    }

    public function cannotCreateSetting()
    {
        $error = ['status' => 400, 'message' => trans('errors.cannotCreateSetting')];
        abort($error['status'], $error['message']);
    }

    public function cannotUpdateSettingKey()
    {
        $error = ['status' => 400, 'message' => trans('errors.cannotUpdateSettingKey')];
        abort($error['status'], $error['message']);
    }

    public function userIsBlocked()
    {
        $error = ['status' => 403, 'message' => trans('errors.userIsBlocked')];
        abort($error['status'], $error['message']);
    }

    public function invalidResetToken()
    {
        $error = ['status' => 400, 'message' => trans('errors.invalidResetToken')];
        abort($error['status'], $error['message']);
    }

    public function invalidResetPassword()
    {
        $error = ['status' => 400, 'message' => trans('errors.invalidResetPassword')];
        abort($error['status'], $error['message']);
    }

    public function invalidOldPassword()
    {
        $error = ['status' => 400, 'message' => trans('errors.invalidOldPassword')];
        abort($error['status'], $error['message']);
    }

    public function notFound($text)
    {
        $error = ['status' => 404, 'message' => trans('errors.notFound', ['replace' => $text])];
        abort($error['status'], $error['message']);
    }

    public function generalError()
    {
        $error = ['status' => 400, 'message' => trans('errors.generalError')];
        abort($error['status'], $error['message']);
    }
}