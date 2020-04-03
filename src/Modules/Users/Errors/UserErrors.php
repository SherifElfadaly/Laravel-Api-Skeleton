<?php

namespace App\Modules\Users\Errors;

class UserErrors
{
    public function unAuthorized()
    {
        $error = ['status' => 401, 'message' => trans('users::errors.unAuthorized')];
        abort($error['status'], $error['message']);
    }

    public function invalidRefreshToken()
    {
        $error = ['status' => 400, 'message' => trans('users::errors.invalidRefreshToken')];
        abort($error['status'], $error['message']);
    }

    public function noPermissions()
    {
        $error = ['status' => 403, 'message' => trans('users::errors.noPermissions')];
        abort($error['status'], $error['message']);
    }

    public function loginFailed()
    {
        $error = ['status' => 400, 'message' => trans('users::errors.loginFailed')];
        abort($error['status'], $error['message']);
    }

    public function noSocialEmail()
    {
        $error = ['status' => 400, 'message' => trans('users::errors.noSocialEmail')];
        abort($error['status'], $error['message']);
    }

    public function userAlreadyRegistered()
    {
        $error = ['status' => 400, 'message' => trans('users::errors.userAlreadyRegistered')];
        abort($error['status'], $error['message']);
    }

    public function userIsBlocked()
    {
        $error = ['status' => 403, 'message' => trans('users::errors.userIsBlocked')];
        abort($error['status'], $error['message']);
    }

    public function emailNotConfirmed()
    {
        $error = ['status' => 403, 'message' => trans('users::errors.emailNotConfirmed')];
        abort($error['status'], $error['message']);
    }

    public function emailAlreadyConfirmed()
    {
        $error = ['status' => 403, 'message' => trans('users::errors.emailAlreadyConfirmed')];
        abort($error['status'], $error['message']);
    }

    public function invalidResetToken()
    {
        $error = ['status' => 400, 'message' => trans('users::errors.invalidResetToken')];
        abort($error['status'], $error['message']);
    }

    public function invalidResetPassword()
    {
        $error = ['status' => 400, 'message' => trans('users::errors.invalidResetPassword')];
        abort($error['status'], $error['message']);
    }

    public function invalidOldPassword()
    {
        $error = ['status' => 400, 'message' => trans('users::errors.invalidOldPassword')];
        abort($error['status'], $error['message']);
    }

    public function invalidConfirmationCode()
    {
        $error = ['status' => 400, 'message' => trans('users::errors.invalidConfirmationCode')];
        abort($error['status'], $error['message']);
    }
}
