<?php
namespace App\Modules\Logging\Http\Controllers\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Modules\Core\Http\Controllers\BaseApiController;

class LogsController extends BaseApiController
{
	/**
     * The name of the model that is used by the base api controller 
     * to preform actions like (add, edit ... etc).
     * @var string
     */
    protected $model            = 'logs';
}
