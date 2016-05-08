<?php
namespace App\Modules\V1\Acl\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use App\Modules\V1\Core\Http\Controllers\BaseApiController;
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
    protected $skipPermissionCheck = ['account', 'logout', 'sendreset'];

    /**
     * List of all route actions that the base api controller
     * will skip login check for them.
     * @var array
     */
    protected $skipLoginCheck      = ['login', 'loginSocial', 'register', 'sendreset', 'resetpassword'];

    /**
     * The validations rules used by the base api controller
     * to check before add.
     * @var array
     */
    protected $validationRules     = [
    'email'    => 'required|email|unique:users,email,{id}',
    'password' => 'min:6'
    ];

    /**
     * Return the logged in user account.
     * 
     * @return \Illuminate\Http\Response
     */
    public function account()
    {
       $relations = $this->relations && $this->relations['find'] ? $this->relations['find'] : [];
       return \Response::json(call_user_func_array("\Core::{$this->model}", [])->find(\JWTAuth::parseToken()->authenticate()->id, $relations), 200);
    }

    /**
     * Block the user.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function block($id)
    {
        return \Response::json(\Core::users()->block($id), 200);
    }

    /**
     * Unblock the user.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function unblock($id)
    {
        return \Response::json(\Core::users()->unblock($id), 200);
    }

    /**
     * Logout the user.
     * 
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        return \Response::json(\Core::users()->logout(), 200);
    }

    /**
     * Handle a registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|unique:users,email,{id}', 
            'password' => 'required|min:6'
            ]);

        return \Response::json(\Core::users()->register($request->only('email', 'password')), 200);
    }

    /**
     * Handle a login request of the none admin to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email', 
            'password' => 'required|min:6',
            'admin'    => 'boolean'
            ]);

        return \Response::json(\Core::users()->login($request->only('email', 'password'), $request->get('admin')), 200);
    }

    /**
     * Handle a social login request of the none admin to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loginSocial(Request $request)
    {
        $this->validate($request, [
            'email'        => 'required|email', 
            'access_token' => 'required'
            ]);

        return \Response::json(\Core::users()->loginSocial($request->only('email', 'access_token', 'old_access_token')), 200);
    }

    /**
     * Handle an assign groups to user request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assigngroups(Request $request)
    {
        $this->validate($request, [
            'group_ids' => 'required|exists:groups,id', 
            'user_id'   => 'required|exists:users,id'
            ]);

        return \Response::json(\Core::users()->assignGroups($request->get('user_id'), $request->get('group_ids')), 200);
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendreset(Request $request)
    {
        $this->validate($request, ['email' => 'required|email', 'url' => 'required|url']);

        return \Response::json(\Core::users()->sendReset($request->only('email'), $request->get('url')), 200);
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resetpassword(Request $request)
    {
        $this->validate($request, [
            'token'                 => 'required',
            'email'                 => 'required|email',
            'password'              => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
        ]);

        return \Response::json(\Core::users()->resetPassword($request->only('email', 'password', 'password_confirmation', 'token')), 200);
    }
}
