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
    protected $skipPermissionCheck = ['account', 'logout', 'changePassword'];

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
        'name'     => 'nullable|string', 
        'email'    => 'required|email|unique:users,email,{id}', 
        'password' => 'nullable|min:6'
    ];

    /**
     * Return the logged in user account.
     * 
     * @return \Illuminate\Http\Response
     */
    public function account()
    {
        return \Response::json(\Core::users()->account($this->relations), 200);
    }

    /**
     * Block the user.
     *
     * @param  integer  $id Id of the user.
     * @return \Illuminate\Http\Response
     */
    public function block($id)
    {
        return \Response::json(\Core::users()->block($id), 200);
    }

    /**
     * Unblock the user.
     *
     * @param  integer  $id Id of the user.
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
            'name'     => 'nullable|string', 
            'email'    => 'required|email|unique:users,email,{id}', 
            'password' => 'required|min:6'
            ]);

        return \Response::json(\Core::users()->register($request->only('email', 'password')), 200);
    }

    /**
     * Handle a login request to the application.
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
     * Assign the given groups to the given user.
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
        $this->validate($request, ['email' => 'required|email']);

        return \Response::json(\Core::users()->sendReset($request->only('email')), 200);
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
     * @param  \Illuminate\Http\Request  $request
     * @param  string $groupName The name of the requested group.
     * @param  integer $perPage  Number of rows per page default 15.
     * @param  string  $sortBy   The name of the column to sort by.
     * @param  boolean $desc     Sort ascending or descinding (1: desc, 0: asc).
     * @return \Illuminate\Http\Response
     */
    public function group(Request $request, $groupName, $perPage = false, $sortBy = 'created_at', $desc = 1)
    {
        return \Response::json(\Core::users()->group($request->all(), $groupName, $this->relations, $perPage, $sortBy, $desc), 200);
    }

    /**
     * Save the given data to the logged in user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveProfile(Request $request) 
    {
        foreach ($this->validationRules as &$rule) 
        {
            if (strpos($rule, 'exists') && ! strpos($rule, 'deleted_at,NULL')) 
            {
                $rule .= ',deleted_at,NULL';
            }

            if ($request->has('id')) 
            {
                $rule = str_replace('{id}', $request->get('id'), $rule);
            }
            else
            {
                $rule = str_replace(',{id}', '', $rule);
            }
        }

        $this->validate($request, $this->validationRules);

        if ($this->model)
        {
            return \Response::json(call_user_func_array("\Core::{$this->model}", [])->saveProfile($request->all()), 200);
        }
    }
}
