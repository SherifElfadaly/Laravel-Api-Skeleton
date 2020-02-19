<?php namespace App\Modules\Core\Utl;

class ErrorHandler
{
    public function unAuthorized()
    {
        $error = ['status' => 401, 'message' => trans('core::errors.unAuthorized')];
        abort($error['status'], $error['message']);
    }

    public function invalidRefreshToken()
    {
        $error = ['status' => 400, 'message' => trans('core::errors.invalidRefreshToken')];
        abort($error['status'], $error['message']);
    }

    public function noPermissions()
    {
        $error = ['status' => 403, 'message' => trans('core::errors.noPermissions')];
        abort($error['status'], $error['message']);
    }

    public function loginFailed()
    {
        $error = ['status' => 400, 'message' => trans('core::errors.loginFailed')];
        abort($error['status'], $error['message']);
    }

    public function noSocialEmail()
    {
        $error = ['status' => 400, 'message' => trans('core::errors.noSocialEmail')];
        abort($error['status'], $error['message']);
    }

    public function userAlreadyRegistered()
    {
        $error = ['status' => 400, 'message' => trans('core::errors.userAlreadyRegistered')];
        abort($error['status'], $error['message']);
    }

    public function connectionError()
    {
        $error = ['status' => 400, 'message' => trans('core::errors.connectionError')];
        abort($error['status'], $error['message']);
    }

    public function redisNotRunning()
    {
        $error = ['status' => 400, 'message' => trans('core::errors.redisNotRunning')];
        abort($error['status'], $error['message']);
    }

    public function dbQueryError()
    {
        $error = ['status' => 400, 'message' => trans('core::errors.dbQueryError')];
        abort($error['status'], $error['message']);
    }

    public function cannotCreateSetting()
    {
        $error = ['status' => 400, 'message' => trans('core::errors.cannotCreateSetting')];
        abort($error['status'], $error['message']);
    }

    public function cannotUpdateSettingKey()
    {
        $error = ['status' => 400, 'message' => trans('core::errors.cannotUpdateSettingKey')];
        abort($error['status'], $error['message']);
    }

    public function userIsBlocked()
    {
        $error = ['status' => 403, 'message' => trans('core::errors.userIsBlocked')];
        abort($error['status'], $error['message']);
    }

    public function emailNotConfirmed()
    {
        $error = ['status' => 403, 'message' => trans('core::errors.emailNotConfirmed')];
        abort($error['status'], $error['message']);
    }

    public function emailAlreadyConfirmed()
    {
        $error = ['status' => 403, 'message' => trans('core::errors.emailAlreadyConfirmed')];
        abort($error['status'], $error['message']);
    }

    public function invalidResetToken()
    {
        $error = ['status' => 400, 'message' => trans('core::errors.invalidResetToken')];
        abort($error['status'], $error['message']);
    }

    public function invalidResetPassword()
    {
        $error = ['status' => 400, 'message' => trans('core::errors.invalidResetPassword')];
        abort($error['status'], $error['message']);
    }

    public function invalidOldPassword()
    {
        $error = ['status' => 400, 'message' => trans('core::errors.invalidOldPassword')];
        abort($error['status'], $error['message']);
    }

    public function invalidConfirmationCode()
    {
        $error = ['status' => 400, 'message' => trans('core::errors.invalidConfirmationCode')];
        abort($error['status'], $error['message']);
    }

    public function notFound($text)
    {
        $error = ['status' => 404, 'message' => trans('core::errors.notFound', ['replace' => $text])];
        abort($error['status'], $error['message']);
    }

    public function generalError()
    {
        $error = ['status' => 400, 'message' => trans('core::errors.generalError')];
        abort($error['status'], $error['message']);
    }
}
