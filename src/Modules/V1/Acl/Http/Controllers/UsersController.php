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
    protected $skipPermissionCheck = ['account', 'logout', 'block', 'unblock', 'editprofile'];

    /**
     * List of all route actions that the base api controller
     * will skip login check for them.
     * @var array
     */
    protected $skipLoginCheck      = ['login', 'register'];

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
     * @return object
     */
    public function getAccount()
    {
       $relations = $this->relations && $this->relations['find'] ? $this->relations['find'] : [];
       return \Response::json(call_user_func_array("\Core::{$this->model}", [])->find(\JWTAuth::parseToken()->authenticate()->id, $relations), 200);
    }

    /**
     * Block the user.
     *
     * @param  integer  $user_id
     * @return void
     */
    public function getBlock($user_id)
    {
        return \Response::json(\Core::users()->block($user_id), 200);
    }

    /**
     * Unblock the user.
     *
     * @param  integer  $user_id
     * @return void
     */
    public function getUnblock($user_id)
    {
        return \Response::json(\Core::users()->unblock($user_id), 200);
    }

    /**
     * Logout the user.
     * 
     * @return void
     */
    public function getLogout()
    {
        return \Response::json(\Core::users()->logout(), 200);
    }

    /**
     * Handle a registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|unique:users,email,{id}', 
            'password' => 'required|min:6'
            ]);

        return \Response::json(\Core::users()->login($request->only('email', 'password')), 200);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email', 
            'password' => 'required|min:6'
            ]);

        return \Response::json(\Core::users()->login($request->only('email', 'password')), 200);
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

    /**
     * Handle the editing of the user profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postEditprofile(Request $request)
    {
        return \Response::json(\Core::users()->editProfile($request->all()), 200);
    }
}
