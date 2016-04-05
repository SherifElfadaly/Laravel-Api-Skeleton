<?php
namespace App\Modules\V1\Core\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Modules\V1\Core\Http\Controllers\BaseApiController;

class LogsController extends BaseApiController
{
	/**
     * The name of the model that is used by the base api controller 
     * to preform actions like (add, edit ... etc).
     * @var string
     */
    protected $model            = 'logs';
}
