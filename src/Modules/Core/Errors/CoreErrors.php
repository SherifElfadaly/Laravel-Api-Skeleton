<?php

namespace App\Modules\Core\Errors;

class CoreErrors
{
    public function connectionError()
    {
        abort(500, trans('core::errors.connectionError'));
    }

    public function redisNotRunning()
    {
        abort(500, trans('core::errors.redisNotRunning'));
    }

    public function dbQueryError()
    {
        abort(500, trans('core::errors.dbQueryError'));
    }

    public function cannotCreateSetting()
    {
        abort(400, trans('core::errors.cannotCreateSetting'));
    }

    public function cannotUpdateSettingKey()
    {
        abort(400, trans('core::errors.cannotUpdateSettingKey'));
    }

    public function notFound($text)
    {
        abort(404, trans('core::errors.notFound', ['replace' => $text]));
    }
}
