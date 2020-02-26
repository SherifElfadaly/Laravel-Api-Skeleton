<?php namespace App\Modules\Acl\Repositories;

use App\Modules\Core\BaseClasses\BaseRepository;
use Illuminate\Support\Arr;
use App\Modules\Acl\AclUser;

class UserRepository extends BaseRepository
{
    /**
     * Init new object.
     *
     * @param   AclUser $model
     * @return  void
     */
    public function __construct(AclUser $model)
    {
        parent::__construct($model);
    }

    /**
     * Return the logged in user account.
     *
     * @param  array   $relations
     * @return boolean
     */
    public function account($relations = [])
    {
        $permissions = [];
        $user        = $this->find(\Auth::id(), $relations);
        foreach ($user->groups()->get() as $group) {
            $group->permissions->each(function ($permission) use (&$permissions) {
                $permissions[$permission->model][$permission->id] = $permission->name;
            });
        }
        $user->permissions = $permissions;

        return $user;
    }

    /**
     * Check if the logged in user or the given user
     * has the given permissions on the given model.
     *
     * @param  string $nameOfPermission
     * @param  string $model
     * @param  mixed  $user
     * @return boolean
     */
    public function can($nameOfPermission, $model, $user = false)
    {
        $user        = $user ?: $this->find(\Auth::id(), ['groups.permissions']);
        $permissions = [];

        $user->groups->pluck('permissions')->each(function ($permission) use (&$permissions, $model) {
            $permissions = array_merge($permissions, $permission->where('model', $model)->pluck('name')->toArray());
        });

        return in_array($nameOfPermission, $permissions);
    }

    /**
     * Check if the logged in user has the given group.
     *
     * @param  string[] $groups
     * @param  mixed $user
     * @return boolean
     */
    public function hasGroup($groups, $user = false)
    {
        $user = $user ?: $this->find(\Auth::id());
        return $user->groups->whereIn('name', $groups)->count() ? true : false;
    }

    /**
     * Assign the given group ids to the given user.
     *
     * @param  integer $userId
     * @param  array   $groupIds
     * @return object
     */
    public function assignGroups($userId, $groupIds)
    {
        \DB::transaction(function () use ($userId, $groupIds) {
            $user = $this->find($userId);
            $user->groups()->detach();
            $user->groups()->attach($groupIds);
        });

        return $this->find($userId);
    }


    /**
     * Handle a login request to the application.
     *
     * @param  array   $credentials
     * @param  boolean $adminLogin
     * @return object
     */
    public function login($credentials, $adminLogin = false)
    {
        if (! $user = $this->first(['email' => $credentials['email']])) {
            \ErrorHandler::loginFailed();
        } elseif ($adminLogin && ! $user->groups->whereIn('name', ['Admin'])->count()) {
            \ErrorHandler::loginFailed();
        } elseif (! $adminLogin && $user->groups->whereIn('name', ['Admin'])->count()) {
            \ErrorHandler::loginFailed();
        } elseif ($user->blocked) {
            \ErrorHandler::userIsBlocked();
        } elseif (! config('skeleton.disable_confirm_email') && ! $user->confirmed) {
            \ErrorHandler::emailNotConfirmed();
        }

        return $user;
    }

    /**
     * Handle a social login request of the none admin to the application.
     *
     * @param  string $authCode
     * @param  string $accessToken
     * @param  string $type
     * @return array
     */
    public function loginSocial($authCode, $accessToken, $type)
    {
        $access_token = $authCode ? Arr::get(\Socialite::driver($type)->getAccessTokenResponse($authCode), 'access_token') : $accessToken;
        $user         = \Socialite::driver($type)->userFromToken($access_token);

        if (! $user->email) {
            \ErrorHandler::noSocialEmail();
        }

        if (! $this->model->where('email', $user->email)->first()) {
            $this->register(['email' => $user->email, 'password' => ''], true);
        }

        $loginProxy = \App::make('App\Modules\Acl\Proxy\LoginProxy');
        return $loginProxy->login(['email' => $user->email, 'password' => config('skeleton.social_pass')], 0);
    }
    
    /**
     * Handle a registration request.
     *
     * @param  array   $credentials
     * @param  boolean $skipConfirmEmail
     * @return array
     */
    public function register($credentials, $skipConfirmEmail = false)
    {
        $user = $this->save($credentials);

        if ($skipConfirmEmail) {
            $user->confirmed = 1;
            $user->save();
        } elseif (! config('skeleton.disable_confirm_email')) {
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
        if (! $user = $this->find($userId)) {
            \ErrorHandler::notFound('user');
        }
        if (! $this->hasGroup(['Admin'])) {
            \ErrorHandler::noPermissions();
        } elseif (\Auth::id() == $userId) {
            \ErrorHandler::noPermissions();
        } elseif ($user->groups->pluck('name')->search('Admin', true) !== false) {
            \ErrorHandler::noPermissions();
        }

        $user->blocked = 1;
        $user->save();
        
        return $user;
    }

    /**
     * Unblock the user.
     *
     * @param  integer $userId
     * @return object
     */
    public function unblock($userId)
    {
        if (! $this->hasGroup(['Admin'])) {
            \ErrorHandler::noPermissions();
        }

        $user          = $this->find($userId);
        $user->blocked = 0;
        $user->save();

        return $user;
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  string  $email
     * @return void
     */
    public function sendReset($email)
    {
        if (! $user = $this->model->where('email', $email)->first()) {
            \ErrorHandler::notFound('email');
        }

        $token = \Password::getRepository()->create($user);
        \Core::notifications()->notify($user, 'ResetPassword', $token);
    }

    /**
     * Reset the given user's password.
     *
     * @param  array  $credentials
     * @return string|null
     */
    public function resetPassword($credentials)
    {
        $response = \Password::reset($credentials, function ($user, $password) {
            $user->password = $password;
            $user->save();
        });

        switch ($response) {
            case \Password::PASSWORD_RESET:
                return 'success';

            case \Password::INVALID_TOKEN:
                \ErrorHandler::invalidResetToken('token');
                //no break

            case \Password::INVALID_PASSWORD:
                \ErrorHandler::invalidResetPassword('email');
                //no break

            case \Password::INVALID_USER:
                \ErrorHandler::notFound('user');
                //no break

            default:
                \ErrorHandler::generalError();
        }
    }

    /**
     * Change the logged in user password.
     *
     * @param  array  $credentials
     * @return void
     */
    public function changePassword($credentials)
    {
        $user = \Auth::user();
        if (! \Hash::check($credentials['old_password'], $user->password)) {
            \ErrorHandler::invalidOldPassword();
        }

        $user->password = $credentials['password'];
        $user->save();
    }

    /**
     * Confirm email using the confirmation code.
     *
     * @param  string $confirmationCode
     * @return void
     */
    public function confirmEmail($confirmationCode)
    {
        if (! $user = $this->first(['confirmation_code' => $confirmationCode])) {
            \ErrorHandler::invalidConfirmationCode();
        }

        $user->confirmed         = 1;
        $user->confirmation_code = null;
        $user->save();
    }

    /**
     * Send the confirmation mail.
     *
     * @param  string $email
     * @return void
     */
    public function sendConfirmationEmail($email)
    {
        $user = $this->first(['email' => $email]);
        if ($user->confirmed) {
            \ErrorHandler::emailAlreadyConfirmed();
        }

        $user->confirmed         = 0;
        $user->confirmation_code = sha1(microtime());
        $user->save();
        \Core::notifications()->notify($user, 'ConfirmEmail');
    }

    /**
     * Paginate all users in the given group based on the given conditions.
     *
     * @param  string  $groupName
     * @param  array   $relations
     * @param  integer $perPage
     * @param  string  $sortBy
     * @param  boolean $desc
     * @return \Illuminate\Http\Response
     */
    public function group($conditions, $groupName, $relations, $perPage, $sortBy, $desc)
    {
        unset($conditions['page']);
        $conditions = $this->constructConditions($conditions, $this->model);
        $sort       = $desc ? 'desc' : 'asc';
        $model      = $this->model->with($relations);

        $model->whereHas('groups', function ($q) use ($groupName) {
            $q->where('name', $groupName);
        });

        
        if (count($conditions['conditionValues'])) {
            $model->whereRaw($conditions['conditionString'], $conditions['conditionValues']);
        }

        if ($perPage) {
            return $model->orderBy($sortBy, $sort)->paginate($perPage);
        }

        return $model->orderBy($sortBy, $sort)->get();
    }

    /**
     * Save the given data to the logged in user.
     *
     * @param  array $data
     * @return void
     */
    public function saveProfile($data)
    {
        if (Arr::has($data, 'profile_picture')) {
            $data['profile_picture'] = \Media::uploadImageBas64($data['profile_picture'], 'admins/profile_pictures');
        }
        
        $data['id'] = \Auth::id();
        return $this->save($data);
    }

    /**
     * Ensure access token hasn't expired or revoked.
     *
     * @param  string $accessToken
     * @return boolean
     */
    public function accessTokenExpiredOrRevoked($accessToken)
    {
        $accessTokenId = json_decode($accessToken, true)['id'];
        $accessToken   = \DB::table('oauth_access_tokens')
                ->where('id', $accessTokenId)
                ->first();
        
        if (\Carbon\Carbon::parse($accessToken->expires_at)->isPast() || $accessToken->revoked) {
            return true;
        }

        return false;
    }

    /**
     * Revoke the given access token and all
     * associated refresh tokens.
     *
     * @param  oject $accessToken
     * @return void
     */
    public function revokeAccessToken($accessToken)
    {
        \DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();
    }
}
