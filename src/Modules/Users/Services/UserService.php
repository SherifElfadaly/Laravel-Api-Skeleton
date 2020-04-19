<?php

namespace App\Modules\Users\Services;

use App\Modules\Core\BaseClasses\BaseService;
use Illuminate\Support\Arr;
use App\Modules\Users\Repositories\UserRepository;
use App\Modules\Permissions\Services\PermissionService;
use App\Modules\OauthClients\Services\OauthClientService;
use App\Modules\Notifications\Services\NotificationService;
use App\Modules\Users\Proxy\LoginProxy;

class UserService extends BaseService
{
    /**
     * @var PermissionService
     */
    protected $permissionService;

    /**
     * @var LoginProxy
     */
    protected $loginProxy;

    /**
     * @var NotificationService
     */
    protected $notificationService;

    /**
     * @var OauthClientService
     */
    protected $oauthClientService;

    /**
     * Init new object.
     *
     * @param   UserRepository       $repo
     * @param   PermissionService    $permissionService
     * @param   LoginProxy           $loginProxy
     * @param   NotificationService  $notificationService
     * @param   OauthClientService   $oauthClientService
     * @return  void
     */
    public function __construct(
        UserRepository $repo,
        PermissionService $permissionService,
        LoginProxy $loginProxy,
        NotificationService $notificationService,
        OauthClientService $oauthClientService
    ) {
        $this->permissionService   = $permissionService;
        $this->loginProxy          = $loginProxy;
        $this->notificationService = $notificationService;
        $this->oauthClientService  = $oauthClientService;
        parent::__construct($repo);
    }

    /**
     * Return the logged in user account.
     *
     * @param  array   $relations
     * @return boolean
     */
    public function account($relations = ['roles.permissions'])
    {
        $permissions = [];
        $user        = $this->repo->find(\Auth::id(), $relations);
        foreach ($user->roles as $role) {
            $role->permissions->each(function ($permission) use (&$permissions) {
                $permissions[$permission->repo][$permission->id] = $permission->name;
            });
        }
        $user->permissions = $permissions;

        return $user;
    }

    /**
     * Check if the logged in user or the given user
     * has the given permissions on the given model.
     *
     * @param  string $permissionName
     * @param  string $model
     * @param  mixed  $userId
     * @return boolean
     */
    public function can($permissionName, $model, $userId = false)
    {
        $permission = $this->permissionService->first([
            'and' => [
                'model' => $model,
                'name'  => $permissionName,
                'roles' => [
                    'op' => 'has',
                    'val' => [
                        'users' => [
                            'op' => 'has',
                            'val' => [
                                'users.id' => $userId ?: \Auth::id()
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        return $permission ? true : false;
    }

    /**
     * Check if the logged in or the given user has the given role.
     *
     * @param  string[] $roles
     * @param  mixed    $user
     * @return boolean
     */
    public function hasRoles($roles, $user = false)
    {
        return $this->repo->countRoles($user ?: \Auth::id(), $roles) ? true : false;
    }

    /**
     * Assign the given role ids to the given user.
     *
     * @param  integer $userId
     * @param  array   $roleIds
     * @return object
     */
    public function assignRoles($userId, $roleIds)
    {
        $user = false;
        \DB::transaction(function () use ($userId, $roleIds, &$user) {
            $user = $this->repo->find($userId);
            $this->repo->detachPermissions($userId);
            $this->repo->attachPermissions($userId, $roleIds);
        });

        return $user;
    }

    /**
     * Handle the login request to the application.
     *
     * @param  string  $email
     * @param  string  $password
     * @param  string  $role
     * @return object
     */
    public function login($email, $password, $role = false)
    {
        if (! $user = $this->repo->first(['email' => $email])) {
            \Errors::loginFailed();
        } elseif ($user->blocked) {
            \Errors::userIsBlocked();
        } elseif (! config('skeleton.disable_confirm_email') && ! $user->confirmed) {
            \Errors::emailNotConfirmed();
        }

        return ['user' => $user, 'tokens' => $this->loginProxy->login($user->email, $password)];
    }

    /**
     * Handle the social login request to the application.
     *
     * @param  string $authCode
     * @param  string $accessToken
     * @return array
     */
    public function loginSocial($authCode, $accessToken, $type)
    {
        $access_token = $authCode ? Arr::get(\Socialite::driver($type)->getAccessTokenResponse($authCode), 'access_token') : $accessToken;
        $user         = \Socialite::driver($type)->userFromToken($access_token);

        if (! $user->email) {
            \Errors::noSocialEmail();
        }

        if (! $this->repo->first(['email' => $user->email])) {
            $this->register($user->email, '', true);
        }

        return $this->loginProxy->login($user->email, config('skeleton.social_pass'));
    }
    
    /**
     * Handle the registration request.
     *
     * @param  string  $name
     * @param  string  $email
     * @param  string  $password
     * @param  boolean $skipConfirmEmail
     * @return array
     */
    public function register($name, $email, $password, $skipConfirmEmail = false)
    {
        $user = $this->repo->save([
            'name'      => $name,
            'email'     => $email,
            'password'  => $password,
            'confirmed' => $skipConfirmEmail
        ]);

        if (! $skipConfirmEmail && ! config('skeleton.disable_confirm_email')) {
            $this->sendConfirmationEmail($user->email);
        }

        return $user;
    }
    
    /**
     * Block the user.
     *
     * @param  integer $userId
     * @return object
     */
    public function block($userId)
    {
        if (\Auth::id() == $userId) {
            \Errors::noPermissions();
        }
        
        return $this->repo->save(['id' => $userId, 'blocked' => 1]);
    }

    /**
     * Unblock the user.
     *
     * @param  integer $userId
     * @return object
     */
    public function unblock($userId)
    {
        return $this->repo->save(['id' => $userId, 'blocked' => 0]);
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  string  $email
     * @return void
     */
    public function sendReset($email)
    {
        if (! $user = $this->repo->first(['email' => $email])) {
            \Errors::notFound('email');
        }

        $token = \Password::getService()->create($user);
        $this->notificationService->notify($user, 'ResetPassword', $token);
    }

    /**
     * Reset the given user's password.
     *
     * @param   string  $email
     * @param   string  $password
     * @param   string  $passwordConfirmation
     * @param   string  $token
     * @return string|void
     */
    public function resetPassword($email, $password, $passwordConfirmation, $token)
    {
        $response = \Password::reset([
            'email'                 => $email,
            'password'              => $password,
            'password_confirmation' => $passwordConfirmation,
            'token'                 => $token
        ], function ($user, $password) {
            $this->repo->save(['id' => $user->id, 'password' => $password]);
        });

        switch ($response) {
            case \Password::PASSWORD_RESET:
                return 'success';
                break;

            case \Password::INVALID_TOKEN:
                \Errors::invalidResetToken();
                break;

            case \Password::INVALID_PASSWORD:
                \Errors::invalidResetPassword();
                break;

            case \Password::INVALID_USER:
                \Errors::notFound('user');
                break;
        }
    }

    /**
     * Change the logged in user password.
     *
     * @param  string  $password
     * @param  string  $oldPassword
     * @return void
     */
    public function changePassword($password, $oldPassword)
    {
        $user = \Auth::user();
        if (! \Hash::check($oldPassword, $user->password)) {
            \Errors::invalidOldPassword();
        }

        $this->repo->save(['id' => $user->id, 'password' => $password]);
    }

    /**
     * Confirm email using the confirmation code.
     *
     * @param  string $confirmationCode
     * @return void
     */
    public function confirmEmail($confirmationCode)
    {
        if (! $user = $this->repo->first(['confirmation_code' => $confirmationCode])) {
            \Errors::invalidConfirmationCode();
        }

        $this->repo->save(['id' => $user->id, 'confirmed' => 1, 'confirmation_code' => null]);
    }

    /**
     * Send the confirmation mail.
     *
     * @param  string $email
     * @return void
     */
    public function sendConfirmationEmail($email)
    {
        $user = $this->repo->first(['email' => $email]);
        if ($user->confirmed) {
            \Errors::emailAlreadyConfirmed();
        }

        $this->repo->save(['id' => $user->id, 'confirmation_code' => sha1(microtime())]);
        $this->notificationService->notify($user, 'ConfirmEmail');
    }

    /**
     * Save the given data to the logged in user.
     *
     * @param  string $name
     * @param  string $email
     * @param  string $profilePicture
     * @return void
     */
    public function saveProfile($name, $email, $profilePicture = false)
    {
        if ($profilePicture) {
            $data['profile_picture'] = \Media::uploadImageBas64($profilePicture, 'users/profile_pictures');
        }
        
        $data['id'] = \Auth::id();
        return $this->repo->save([
            'id'             => \Auth::id(),
            'name'           => $name,
            'email'          => $email,
            'profilePicture' => $profilePicture,
        ]);
    }

    /**
     * Logs out the user, revoke access token and refresh token.
     *
     * @return void
     */
    public function logout()
    {
        $this->oauthClientService->revokeAccessToken(\Auth::user()->token());
    }

    /**
     * Attempt to refresh the access token using the given refresh token.
     *
     * @param  string $refreshToken
     * @return array
     */
    public function refreshToken($refreshToken)
    {
        return $this->loginProxy->refreshToken($refreshToken);
    }
}
