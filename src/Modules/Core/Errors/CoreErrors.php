<?php

namespace App\Modules\Core\Errors;

class CoreErrors
{
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
