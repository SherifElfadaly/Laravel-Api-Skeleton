<?php

namespace App\Modules\Users\Errors;

class UsersErrors
{
    public function unAuthorized()
    {
        abort(401, trans('users::errors.unAuthorized'));
    }

    public function noPermissions()
    {
        abort(403, trans('users::errors.noPermissions'));
    }

    public function userIsBlocked()
    {
        abort(403, trans('users::errors.userIsBlocked'));
    }

    public function emailNotConfirmed()
    {
        abort(403, trans('users::errors.emailNotConfirmed'));
    }

    public function loginFailed()
    {
        abort(400, trans('users::errors.loginFailed'));
    }

    public function emailAlreadyConfirmed()
    {
        abort(400, trans('users::errors.emailAlreadyConfirmed'));
    }

    public function noSocialEmail()
    {
        abort(400, trans('users::errors.noSocialEmail'));
    }

    public function userAlreadyRegistered()
    {
        abort(400, trans('users::errors.userAlreadyRegistered'));
    }

    public function invalidRefreshToken()
    {
        abort(422, trans('users::errors.invalidRefreshToken'));
    }

    public function invalidResetToken()
    {
        abort(422, trans('users::errors.invalidResetToken'));
    }

    public function invalidResetPassword()
    {
        abort(422, trans('users::errors.invalidResetPassword'));
    }

    public function invalidOldPassword()
    {
        abort(422, trans('users::errors.invalidOldPassword'));
    }

    public function invalidConfirmationCode()
    {
        abort(422, trans('users::errors.invalidConfirmationCode'));
    }
}
