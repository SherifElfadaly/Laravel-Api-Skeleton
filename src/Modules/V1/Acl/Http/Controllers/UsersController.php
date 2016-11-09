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
    protected $skipLoginCheck      = ['login', 'loginSocial', 'register', 'sendreset', 'resetpassword', 'refreshtoken'];

    /**
     * The validations rules used by the base api controller
     * to check before add.
     * @var array
     */
    protected $validationRules     = [
        'full_name'     => 'string|max:100', 
        'user_name'     => 'string|unique:users,user_name,{id}', 
        'email'         => 'required|email|unique:users,email,{id}', 
        'mobile_number' => 'string|unique:users,mobile_number,{id}', 
        'password'      => 'required|min:6'
    ];

    /**
     * Return the logged in user account.
     * 
     * @return \Illuminate\Http\Response
     */
    public function account()
    {
        $relations = $this->relations && $this->relations['account'] ? $this->relations['account'] : [];
        return \Response::json(\Core::users()->account($relations), 200);
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
            'full_name'     => 'string|max:100', 
            'user_name'     => 'string|unique:users,user_name,{id}', 
            'email'         => 'required|email|unique:users,email,{id}', 
            'mobile_number' => 'string|unique:users,mobile_number,{id}', 
            'password'      => 'required|min:6'
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
            'auth_code'    => 'required_without:access_token',
            'access_token' => 'required_without:auth_code',
            'type'         => 'required|in:facebook,google'
            ]);

        return \Response::json(\Core::users()->loginSocial($request->only('auth_code', 'access_token', 'type')), 200);
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

    /**
     * Change the logged in user password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'old_password'          => 'required',
            'password'              => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
        ]);

        return \Response::json(\Core::users()->changePassword($request->only('old_password', 'password', 'password_confirmation')), 200);
    }

    /**
     * Refresh the expired login token.
     *
     * @return \Illuminate\Http\Response
     */
    public function refreshtoken()
    {
        return \Response::json(\Core::users()->refreshtoken(), 200);
    }

    /**
     * Paginate all users with inthe given group.
     * 
     * @param  string $groupName
     * @param  integer $perPage
     * @param  string  $sortBy
     * @param  boolean $desc
     * @return \Illuminate\Http\Response
     */
    public function group($groupName, $perPage = 15, $sortBy = 'created_at', $desc = 1)
    {
        $relations = $this->relations && $this->relations['group'] ? $this->relations['group'] : [];
        return \Response::json(\Core::users()->group($groupName, $relations, $perPage, $sortBy, $desc), 200);
    }
}
