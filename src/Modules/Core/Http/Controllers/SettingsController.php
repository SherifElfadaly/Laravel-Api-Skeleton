<?php
namespace App\Modules\Core\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use App\Modules\Core\Http\Controllers\BaseApiController;
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
        'id'    => 'required|exists:settings,id',
        'value' => 'required|string'
    ];
    
    /**
     * Save list of settings.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveMany(Request $request) 
    {   
        return \Response::json($this->repo->saveMany($request->all()), 200);
    }
}
