<?php
namespace App\Modules\Acl\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use App\Modules\Core\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;

class PermissionsController extends BaseApiController
{
    /**
     * The name of the model that is used by the base api controller 
     * to preform actions like (add, edit ... etc).
     * @var string
     */
    protected $model = 'permissions';
}
