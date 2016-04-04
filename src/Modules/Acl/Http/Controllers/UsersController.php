<?php
namespace App\Modules\Acl\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use App\Modules\Core\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;

class UsersController extends BaseApiController
{
    /**
     * The name of the model that is used by the base api controller 
     * to preform actions like (add, edit ... etc).
     * @var string
     */
    protected $model               = 'users';

    /**
     * List of all route actions that the base api controller
     * will skip permissions check for them.
     * @var array
     */
    protected $skipPermissionCheck = ['account', 'logout'];

    /**
     * List of all route actions that the base api controller
     * will skip login check for them.
     * @var array
     */
    protected $skipLoginCheck = ['login', 'register'];

    /**
     * The validations rules used by the base api controller
     * to check before add.
     * @var array
     */
    protected $validationRules  = [
    'email'    => 'required|email|unique:users,email,{id}',
    'password' => 'min:6'
    ];

    /**
     * Return the logged in user account.
     * 
     * @return object
     */
    public function getAccount()
    {
       $relations = $this->relations && $this->relations['find'] ? $this->relations['find'] : [];
       return \Response::json(call_user_func_array("\Core::{$this->model}", [])->find(\JWTAuth::parseToken()->authenticate()->id, $relations), 200);
    }

    /**
     * Logout the user.
     * 
     * @return void
     */
    public function getLogout()
    {
        return \Response::json(\JWTAuth::invalidate(\JWTAuth::getToken()), 200);
    }

    /**
     * Handle a registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $this->validate($request, ['email' => 'required|email|unique:users,email,{id}', 'password' => 'required|min:6']);

        $credentials = $request->only('email', 'password');
        $token       = \JWTAuth::fromUser(\Core::users()->model->create($credentials));
        return \Response::json($token, 200);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = \JWTAuth::attempt($credentials))
        {
            $relations = $this->relations && $this->relations['find'] ? $this->relations['find'] : [];
            return \Response::json($token, 200);
        }
        else
        {
            $error = \ErrorHandler::loginFailed();
            abort($error['status'], $error['message']);
        }
    }

    /**
     * Handle an assign groups to user request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postAssigngroups(Request $request)
    {
        $this->validate($request, [
            'group_ids' => 'required|exists:groups,id', 
            'user_id'   => 'required|exists:users,id'
            ]);

        return \Response::json(\Core::users()->assignGroups($request->get('user_id'), $request->get('group_ids')), 200);
    }
}
