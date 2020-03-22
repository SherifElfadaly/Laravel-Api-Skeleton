<?php

namespace App\Modules\Users\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Core\BaseClasses\BaseApiController;
use App\Modules\Users\Repositories\UserRepository;
use App\Modules\Users\Proxy\LoginProxy;
use App\Modules\Core\Http\Resources\General as GeneralResource;
use Illuminate\Support\Facades\App;
use App\Modules\Users\Http\Requests\AssignRoles;
use App\Modules\Users\Http\Requests\ChangePassword;
use App\Modules\Users\Http\Requests\Login;
use App\Modules\Users\Http\Requests\LoginSocial;
use App\Modules\Users\Http\Requests\RefreshToken;
use App\Modules\Users\Http\Requests\Register;
use App\Modules\Users\Http\Requests\ResendEmailConfirmation;
use App\Modules\Users\Http\Requests\ResetPassword;
use App\Modules\Users\Http\Requests\SaveProfile;
use App\Modules\Users\Http\Requests\SendReset;
use App\Modules\Users\Http\Requests\ConfirmEmail;
use App\Modules\Users\Http\Requests\InsertUser;
use App\Modules\Users\Http\Requests\UpdateUser;

class UserController extends BaseApiController
{
    /**
     * List of all route actions that the base api controller
     * will skip permissions check for them.
     * @var array
     */
    protected $skipPermissionCheck = ['account', 'logout', 'changePassword', 'saveProfile'];

    /**
     * List of all route actions that the base api controller
     * will skip login check for them.
     * @var array
     */
    protected $skipLoginCheck = ['login', 'loginSocial', 'register', 'sendReset', 'resetPassword', 'refreshToken', 'confirmEmail', 'resendEmailConfirmation'];

    /**
     * The loginProxy implementation.
     *
     * @var App\Modules\Users\Proxy\LoginProxy
     */
    protected $loginProxy;

    /**
     * Init new object.
     *
     * @param   LoginProxy     $loginProxy
     * @param   UserRepository $repo
     * @return  void
     */
    public function __construct(LoginProxy $loginProxy, UserRepository $repo)
    {
        $this->loginProxy = $loginProxy;
        parent::__construct($repo, 'App\Modules\Users\Http\Resources\AclUser');
    }

    /**
     * Insert the given model to storage.
     *
     * @param InsertUser $request
     * @return \Illuminate\Http\Response
     */
    public function insert(InsertUser $request)
    {
        return new $this->modelResource($this->repo->save($request->all()));
    }

    /**
     * Update the given model to storage.
     *
     * @param UpdateUser $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request)
    {
        return new $this->modelResource($this->repo->save($request->all()));
    }

    /**
     * Return the logged in user account.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function account(Request $request)
    {
        return new $this->modelResource($this->repo->account($request->relations));
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
     * @param Register $request
     * @return \Illuminate\Http\Response
     */
    public function register(Register $request)
    {
        return new $this->modelResource($this->repo->register($request->only('name', 'email', 'password')));
    }

    /**
     * Handle a login request to the application.
     *
     * @param Login $request
     * @return \Illuminate\Http\Response
     */
    public function login(Login $request)
    {
        $result = $this->loginProxy->login($request->only('email', 'password'), $request->get('admin'));

        return (new $this->modelResource($result['user']))->additional(['meta' => $result['tokens']]);
    }

    /**
     * Handle a social login request of the none admin to the application.
     *
     * @param LoginSocial $request
     * @return \Illuminate\Http\Response
     */
    public function loginSocial(LoginSocial $request)
    {
        $result = $this->repo->loginSocial($request->get('auth_code'), $request->get('access_token'), $request->get('type'));

        return (new $this->modelResource($result['user']))->additional(['meta' => $result['tokens']]);
    }

    /**
     * Assign the given roles to the given user.
     *
     * @param AssignRoles $request
     * @return \Illuminate\Http\Response
     */
    public function assignRoles(AssignRoles $request)
    {
        return new $this->modelResource($this->repo->assignRoles($request->get('user_id'), $request->get('role_ids')));
    }

    /**
     * Send a reset link to the given user.
     *
     * @param SendReset $request
     * @return \Illuminate\Http\Response
     */
    public function sendReset(SendReset $request)
    {
        return new GeneralResource($this->repo->sendReset($request->get('email')));
    }

    /**
     * Reset the given user's password.
     *
     * @param ResetPassword $request
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(ResetPassword $request)
    {
        return new GeneralResource($this->repo->resetPassword($request->only('email', 'password', 'password_confirmation', 'token')));
    }

    /**
     * Change the logged in user password.
     *
     * @param ChangePassword $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(ChangePassword $request)
    {
        return new GeneralResource($this->repo->changePassword($request->only('old_password', 'password', 'password_confirmation')));
    }

    /**
     * Confirm email using the confirmation code.
     *
     * @param ConfirmEmail $request
     * @return \Illuminate\Http\Response
     */
    public function confirmEmail(ConfirmEmail $request)
    {
        return new GeneralResource($this->repo->confirmEmail($request->only('confirmation_code')));
    }

    /**
     * Resend the email confirmation mail.
     *
     * @param ResendEmailConfirmation $request
     * @return \Illuminate\Http\Response
     */
    public function resendEmailConfirmation(ResendEmailConfirmation $request)
    {
        return new GeneralResource($this->repo->sendConfirmationEmail($request->get('email')));
    }

    /**
     * Refresh the expired login token.
     *
     * @param RefreshToken $request
     * @return \Illuminate\Http\Response
     */
    public function refreshToken(RefreshToken $request)
    {
        return new GeneralResource($this->loginProxy->refreshToken($request->get('refresh_token')));
    }

    /**
     * Paginate all users with in the given role.
     *
     * @param Request $request
     * @param  string $roleName The name of the requested role.
     * @return \Illuminate\Http\Response
     */
    public function role(Request $request, $roleName)
    {
        return $this->modelResource::collection($this->repo->role($request->all(), $roleName, $request->relations, $request->query('perPage'), $request->query('sortBy'), $request->query('desc')));
    }

    /**
     * Save the given data to the logged in user.
     *
     * @param SaveProfile $request
     * @return \Illuminate\Http\Response
     */
    public function saveProfile(SaveProfile $request)
    {
        return new $this->modelResource($this->repo->saveProfile($request->only('name', 'email', 'profile_picture')));
    }
}
