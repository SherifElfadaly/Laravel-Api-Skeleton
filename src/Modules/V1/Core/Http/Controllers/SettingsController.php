<?php
namespace App\Modules\V1\Core\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use App\Modules\V1\Core\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;


class SettingsController extends BaseApiController
{
    /**
     * The name of the model that is used by the base api controller 
     * to preform actions like (add, edit ... etc).
     * @var string
     */
    protected $model               = 'settings';

    /**
     * The validations rules used by the base api controller
     * to check before add.
     * @var array
     */
    protected $validationRules  = [
    'name'  => 'required|string|max:100',
    'value' => 'required|string|max:100'
    ];
}
