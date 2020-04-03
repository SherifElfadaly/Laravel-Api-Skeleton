<?php

namespace App\Modules\Users\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Core\BaseClasses\BaseApiController;
use App\Modules\Users\Services\UserService;
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
     * Path of the model resource
     *
     * @var string
     */
    protected $modelResource = 'App\Modules\Users\Http\Resources\AclUser';

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
     * Init new object.
     *
     * @param   UserService $service
     * @return  void
     */
    public function __construct(UserService $service)
    {
        parent::__construct($service);
    }

    /**
     * Insert the given model to storage.
     *
     * @param InsertUser $request
     * @return \Illuminate\Http\Response
     */
    public function insert(InsertUser $request)
    {
        return new $this->modelResource($this->service->save($request->all()));
    }

    /**
     * Update the given model to storage.
     *
     * @param UpdateUser $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request)
    {
        return new $this->modelResource($this->service->save($request->all()));
    }

    /**
     * Return the logged in user account.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function account(Request $request)
    {
        return new $this->modelResource($this->service->account($request->relations));
    }

    /**
     * Block the user.
     *
     * @param  integer  $id Id of the user.
     * @return \Illuminate\Http\Response
     */
    public function block($id)
    {
        return new $this->modelResource($this->service->block($id));
    }

    /**
     * Unblock the user.
     *
     * @param  integer  $id Id of the user.
     * @return \Illuminate\Http\Response
     */
    public function unblock($id)
    {
        return new $this->modelResource($this->service->unblock($id));
    }

    /**
     * Logout the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        return new GeneralResource($this->service->logout());
    }

    /**
     * Handle a registration request.
     *
     * @param Register $request
     * @return \Illuminate\Http\Response
     */
    public function register(Register $request)
    {
        return new $this->modelResource($this->service->register($request->get('name'), $request->get('email'), $request->get('password')));
    }

    /**
     * Handle a login request to the application.
     *
     * @param Login $request
     * @return \Illuminate\Http\Response
     */
    public function login(Login $request)
    {
        $result = $this->service->login($request->get('email'), $request->get('password'), $request->get('admin'));

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
        $result = $this->service->loginSocial($request->get('auth_code'), $request->get('access_token'), $request->get('type'));

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
        return new $this->modelResource($this->service->assignRoles($request->get('user_id'), $request->get('role_ids')));
    }

    /**
     * Send a reset link to the given user.
     *
     * @param SendReset $request
     * @return \Illuminate\Http\Response
     */
    public function sendReset(SendReset $request)
    {
        return new GeneralResource($this->service->sendReset($request->get('email')));
    }

    /**
     * Reset the given user's password.
     *
     * @param ResetPassword $request
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(ResetPassword $request)
    {
        return new GeneralResource($this->service->resetPassword($request->get('email'), $request->get('password'), $request->get('password_confirmation'), $request->get('token')));
    }

    /**
     * Change the logged in user password.
     *
     * @param ChangePassword $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(ChangePassword $request)
    {
        return new GeneralResource($this->service->changePassword($request->get('password'), $request->get('old_password')));
    }

    /**
     * Confirm email using the confirmation code.
     *
     * @param ConfirmEmail $request
     * @return \Illuminate\Http\Response
     */
    public function confirmEmail(ConfirmEmail $request)
    {
        return new GeneralResource($this->service->confirmEmail($request->only('confirmation_code')));
    }

    /**
     * Resend the email confirmation mail.
     *
     * @param ResendEmailConfirmation $request
     * @return \Illuminate\Http\Response
     */
    public function resendEmailConfirmation(ResendEmailConfirmation $request)
    {
        return new GeneralResource($this->service->sendConfirmationEmail($request->get('email')));
    }

    /**
     * Refresh the expired login token.
     *
     * @param RefreshToken $request
     * @return \Illuminate\Http\Response
     */
    public function refreshToken(RefreshToken $request)
    {
        return new GeneralResource($this->service->refreshToken($request->get('refresh_token')));
    }

    /**
     * Save the given data to the logged in user.
     *
     * @param SaveProfile $request
     * @return \Illuminate\Http\Response
     */
    public function saveProfile(SaveProfile $request)
    {
        return new $this->modelResource($this->service->saveProfile($request->get('name'), $request->get('email'), $request->get('profile_picture')));
    }
}
