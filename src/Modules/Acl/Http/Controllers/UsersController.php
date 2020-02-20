<?php

namespace App\Modules\Acl\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Core\Http\Controllers\BaseApiController;
use App\Modules\Acl\Repositories\UserRepository;
use App\Modules\Acl\Proxy\LoginProxy;
use App\Modules\Core\Utl\CoreConfig;
use App\Modules\Core\Http\Resources\General as GeneralResource;

class UsersController extends BaseApiController
{
    /**
     * List of all route actions that the base api controller
     * will skip permissions check for them.
     * @var array
     */
    protected $skipPermissionCheck = ['account', 'logout', 'changePassword', 'saveProfile', 'account'];

    /**
     * List of all route actions that the base api controller
     * will skip login check for them.
     * @var array
     */
    protected $skipLoginCheck = ['login', 'loginSocial', 'register', 'sendreset', 'resetpassword', 'refreshtoken', 'confirmEmail', 'resendEmailConfirmation'];

    /**
     * The validations rules used by the base api controller
     * to check before add.
     * @var array
     */
    protected $validationRules = [
        'name'     => 'nullable|string',
        'email'    => 'required|email|unique:users,email,{id}',
        'password' => 'nullable|min:6'
    ];

    /**
     * The loginProxy implementation.
     *
     * @var \App\Modules\Acl\Proxy\LoginProxy
     */
    protected $loginProxy;

    /**
     * Init new object.
     *
     * @param   LoginProxy     $loginProxy
     * @param   UserRepository $repo
     * @param   CoreConfig     $config
     * @return  void
     */
    public function __construct(LoginProxy $loginProxy, UserRepository $repo, CoreConfig $config)
    {
        $this->loginProxy = $loginProxy;
        parent::__construct($repo, $config, 'App\Modules\Acl\Http\Resources\AclUser');
    }

    /**
     * Return the logged in user account.
     *
     * @return \Illuminate\Http\Response
     */
    public function account()
    {
        return new $this->modelResource($this->repo->account($this->relations));
    }

    /**
     * Block the user.
     *
     * @param  integer  $id Id of the user.
     * @return \Illuminate\Http\Response
     */
    public function block($id)
    {
        return new $this->modelResource($this->repo->block($id));
    }

    /**
     * Unblock the user.
     *
     * @param  integer  $id Id of the user.
     * @return \Illuminate\Http\Response
     */
    public function unblock($id)
    {
        return new $this->modelResource($this->repo->unblock($id));
    }

    /**
     * Logout the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        return new GeneralResource($this->loginProxy->logout());
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

        return new $this->modelResource($this->repo->register($request->only('name', 'email', 'password')));
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
            'admin'    => 'nullable|boolean'
            ]);
        
        $result = $this->loginProxy->login($request->only('email', 'password'), $request->get('admin'));
        return (new $this->modelResource($result['user']))->additional(['meta' => $result['tokens']]);
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

        $result = $this->repo->loginSocial($request->get('auth_code'), $request->get('access_token'), $request->get('type'));
        return (new $this->modelResource($result['user']))->additional(['meta' => $result['tokens']]);
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

        return new $this->modelResource($this->repo->assignGroups($request->get('user_id'), $request->get('group_ids')));
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

        return new GeneralResource($this->repo->sendReset($request->get('email')));
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

        return new GeneralResource($this->repo->resetPassword($request->only('email', 'password', 'password_confirmation', 'token')));
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

        return new GeneralResource($this->repo->changePassword($request->only('old_password', 'password', 'password_confirmation')));
    }

    /**
     * Confirm email using the confirmation code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function confirmEmail(Request $request)
    {
        $this->validate($request, [
            'confirmation_code' => 'required|string'
        ]);

        return new GeneralResource($this->repo->confirmEmail($request->only('confirmation_code')));
    }

    /**
     * Resend the email confirmation mail.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resendEmailConfirmation(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|exists:users,email'
        ]);

        return new GeneralResource($this->repo->sendConfirmationEmail($request->get('email')));
    }

    /**
     * Refresh the expired login token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function refreshtoken(Request $request)
    {
        $this->validate($request, [
            'refreshtoken' => 'required',
        ]);

        return new GeneralResource($this->loginProxy->refreshtoken($request->get('refreshtoken')));
    }

    /**
     * Paginate all users with in the given group.
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
        return $this->modelResource::collection($this->repo->group($request->all(), $groupName, $this->relations, $perPage, $sortBy, $desc));
    }

    /**
     * Save the given data to the logged in user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveProfile(Request $request)
    {
        $this->validate($request, [
            'profile_picture' => 'nullable|string',
            'name'            => 'nullable|string',
            'email'           => 'required|email|unique:users,email,'.\Auth::id()
        ]);

        return new $this->modelResource($this->repo->saveProfile($request->only('name', 'email', 'profile_picture')));
    }
}
