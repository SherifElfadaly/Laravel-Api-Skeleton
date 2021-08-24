<?php

namespace App\Modules\Users\Services;

use App\Modules\Core\BaseClasses\BaseService;
use App\Modules\Core\Facades\Errors;
use Illuminate\Support\Arr;
use App\Modules\Notifications\Services\NotificationServiceInterface;
use App\Modules\OauthClients\Services\OauthClientServiceInterface;
use App\Modules\Permissions\Services\PermissionServiceInterface;
use App\Modules\Users\Proxy\LoginProxy;
use App\Modules\Users\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;

class UserService extends BaseService implements UserServiceInterface
{
    /**
     * @var PermissionServiceInterface
     */
    protected $permissionService;

    /**
     * @var LoginProxy
     */
    protected $loginProxy;

    /**
     * @var NotificationServiceInterface
     */
    protected $notificationService;

    /**
     * @var OauthClientServiceInterface
     */
    protected $oauthClientService;

    /**
     * Init new object.
     *
     * @param   UserRepositoryInterface $repo
     * @param   PermissionServiceInterface $permissionService
     * @param   LoginProxy $loginProxy
     * @param   NotificationServiceInterface $notificationService
     * @param   OauthClientServiceInterface $oauthClientService
     * @return  void
     */
    public function __construct(
        UserRepositoryInterface $repo,
        PermissionServiceInterface $permissionService,
        LoginProxy $loginProxy,
        NotificationServiceInterface $notificationService,
        OauthClientServiceInterface $oauthClientService
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
     * @return Model
     */
    public function account(array $relations = ['roles.permissions']): Model
    {
        $permissions = [];
        $user        = $this->repo->find(Auth::id(), $relations);
        foreach ($user->roles as $role) {
            $role->permissions->each(function ($permission) use (&$permissions) {
                $permissions[] = $permission;
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
     * @param  int    $userId
     * @return bool
     */
    public function can(string $permissionName, string $model, int $userId = 0): bool
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
                                'users.id' => $userId ?: Auth::id()
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
     * @param  array $roles
     * @param  int   $user
     * @return bool
     */
    public function hasRoles(array $roles, int $user = 0): bool
    {
        return $this->repo->countRoles($user ?: Auth::id(), $roles) ? true : false;
    }

    /**
     * Assign the given role ids to the given user.
     *
     * @param  int   $userId
     * @param  array $roleIds
     * @return Model
     */
    public function assignRoles(int $userId, array $roleIds): Model
    {
        $user = new Model();
        DB::transaction(function () use ($userId, $roleIds, &$user) {
            $user = $this->repo->find($userId);
            $this->repo->detachRoles($user);
            $this->repo->attachRoles($user, $roleIds);
        });

        return $user;
    }

    /**
     * Handle the login request to the application.
     *
     * @param  string  $email
     * @param  string  $password
     * @return array
     */
    public function login(string $email, string $password): array
    {
        if (!$user = $this->repo->first(['email' => $email])) {
            Errors::loginFailed();
        } elseif ($user->blocked) {
            Errors::userIsBlocked();
        } elseif (!config('user.disable_confirm_email') && !$user->confirmed) {
            Errors::emailNotConfirmed();
        }

        return ['user' => $user, 'tokens' => $this->loginProxy->login($user->email, $password)];
    }

    /**
     * Handle the social login request to the application.
     *
     * @param  string $authCode
     * @param  string $accessToken
     * @param  string $type
     * @return array
     */
    public function loginSocial(string $authCode, string $accessToken, string $type): array
    {
        $accessToken = $authCode ? Arr::get(Socialite::driver($type)->getAccessTokenResponse($authCode), 'access_token') : $accessToken;
        $user        = Socialite::driver($type)->userFromToken($accessToken)->user;

        if (!Arr::has($user, 'email')) {
            Errors::noSocialEmail();
        }

        if (!$this->repo->first(['email' => $user['email']]) && !$this->repo->deleted(['email' => $user['email']])->total()) {
            $this->register(Arr::get($user, 'name'), $user['email'], '', true);
        }

        return $this->login($user['email'], config('user.social_pass'));
    }

    /**
     * Handle the registration request.
     *
     * @param  array $data
     * @param  bool  $skipConfirmEmail
     * @param  int   $roleId
     * @return Model
     */
    public function register(array $data, bool $skipConfirmEmail = false, int $roleId = 0): Model
    {
        $data['confirmed'] = $skipConfirmEmail;

        if ($roleId) {
            $data['roles'] = [['id' => $roleId]];
        }

        $user = $this->repo->save($data);

        if (!$skipConfirmEmail && !config('user.disable_confirm_email')) {
            $this->sendConfirmationEmail($user->email);
        }

        return $user;
    }

    /**
     * Block the user.
     *
     * @param  int $userId
     * @return Model
     */
    public function block(int $userId): Model
    {
        if (Auth::id() == $userId) {
            Errors::noPermissions();
        }

        return $this->repo->save(['id' => $userId, 'blocked' => 1]);
    }

    /**
     * Unblock the user.
     *
     * @param  int $userId
     * @return Model
     */
    public function unblock(int $userId): Model
    {
        return $this->repo->save(['id' => $userId, 'blocked' => 0]);
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  string  $email
     * @return bool
     */
    public function sendReset(string $email): bool
    {
        if (!$user = $this->repo->first(['email' => $email])) {
            Errors::notFound('email');
        }

        $token = Password::createToken($user);
        $this->notificationService->notify($user, 'ResetPassword', $token);

        return true;
    }

    /**
     * Reset the given user's password.
     *
     * @param   string  $email
     * @param   string  $password
     * @param   string  $passwordConfirmation
     * @param   string  $token
     * @return string
     */
    public function resetPassword(string $email, string $password, string $passwordConfirmation, string $token): string
    {
        $response = Password::reset([
            'email'                 => $email,
            'password'              => $password,
            'password_confirmation' => $passwordConfirmation,
            'token'                 => $token
        ], function ($user, $password) {
            $this->repo->save(['id' => $user->id, 'password' => $password]);
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                return 'success';
                break;

            case Password::INVALID_TOKEN:
                Errors::invalidResetToken();
                break;

            case Password::INVALID_USER:
                Errors::notFound('user');
                break;
        }
    }

    /**
     * Change the logged in user password.
     *
     * @param  string  $password
     * @param  string  $oldPassword
     * @return bool
     */
    public function changePassword(string $password, string $oldPassword): bool
    {
        $user = Auth::user();
        if (!Hash::check($oldPassword, $user->password)) {
            Errors::invalidOldPassword();
        }

        $this->repo->save(['id' => $user->id, 'password' => $password]);

        return true;
    }

    /**
     * Confirm email using the confirmation code.
     *
     * @param  string $confirmationCode
     * @return bool
     */
    public function confirmEmail(string $confirmationCode): bool
    {
        if (!$user = $this->repo->first(['confirmation_code' => $confirmationCode])) {
            Errors::invalidConfirmationCode();
        }

        $this->repo->save(['id' => $user->id, 'confirmed' => 1, 'confirmation_code' => null]);

        return true;
    }

    /**
     * Send the confirmation mail.
     *
     * @param  string $email
     * @return bool
     */
    public function sendConfirmationEmail(string $email): bool
    {
        $user = $this->repo->first(['email' => $email]);
        if ($user->confirmed) {
            Errors::emailAlreadyConfirmed();
        }

        $this->repo->save(['id' => $user->id, 'confirmation_code' => sha1(microtime())]);
        $this->notificationService->notify($user, 'ConfirmEmail');

        return true;
    }

    /**
     * Save the given data to the logged in user.
     *
     * @param  array $data
     * @return Model
     */
    public function saveProfile(array $data): Model
    {
        $data['id'] = Auth::id();
        return $this->repo->save($data);
    }

    /**
     * Logs out the user, revoke access token and refresh token.
     *
     * @return bool
     */
    public function logout(): bool
    {
        $this->oauthClientService->revokeAccessToken(Auth::user()->token());
        return true;
    }

    /**
     * Attempt to refresh the access token using the given refresh token.
     *
     * @param  string $refreshToken
     * @return array
     */
    public function refreshToken(string $refreshToken): array
    {
        return $this->loginProxy->refreshToken($refreshToken);
    }
}
