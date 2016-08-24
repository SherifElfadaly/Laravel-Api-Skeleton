<?php namespace App\Modules\V1\Acl\Repositories;

use App\Modules\V1\Core\AbstractRepositories\AbstractRepository;

class UserRepository extends AbstractRepository
{
    /**
     * Return the model full namespace.
     * 
     * @return string
     */
    protected function getModel()
    {
        return 'App\Modules\V1\Acl\AclUser';
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
        $user        = \Core::users()->find(\JWTAuth::parseToken()->authenticate()->id, $relations);
        foreach ($user->groups()->get() as $group)
        {
            $group->permissions->each(function ($permission) use (&$permissions){
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
     * @param  string  $nameOfPermission
     * @param  string  $model            
     * @param  boolean $user
     * @return boolean
     */
    public function can($nameOfPermission, $model, $user = false )
    {      
        $user        = $user ?: \JWTAuth::parseToken()->authenticate();
        $permissions = [];

        if ( ! $user = $this->find($user->id, ['groups.permissions'])) 
        {
            \ErrorHandler::tokenExpired();
        }

        $user->groups->pluck('permissions')->each(function ($permission) use (&$permissions, $model){
            $permissions = array_merge($permissions, $permission->where('model', $model)->pluck('name')->toArray()); 
        });
        
        return in_array($nameOfPermission, $permissions);
    }

    /**
     * Check if the logged in user has the given group.
     * 
     * @param  string  $groupName
     * @return boolean
     */
    public function hasGroup($groupName)
    {
        $groups = $this->find(\JWTAuth::parseToken()->authenticate()->id)->groups;
        return $groups->pluck('name')->search($groupName, true) === false ? false : true;
    }

    /**
     * Assign the given group ids to the given user.
     * 
     * @param  integer $user_id    
     * @param  array   $group_ids
     * @return object
     */
    public function assignGroups($user_id, $group_ids)
    {
        \DB::transaction(function () use ($user_id, $group_ids) {
            $user = $this->find($user_id);
            $user->groups()->detach();
            $user->groups()->attach($group_ids);
        });

        return $this->find($user_id);
    }

    /**
     * Handle a login request to the application.
     * 
     * @param  array   $credentials    
     * @param  boolean $adminLogin
     * @return array
     */
    public function login($credentials, $adminLogin = false)
    {
        if ( ! $user = $this->first(['email' => $credentials['email']])) 
        {
            \ErrorHandler::loginFailed();
        }
        else if ($adminLogin && $user->groups->pluck('name')->search('Admin', true) === false) 
        {
            \ErrorHandler::loginFailed();
        }
        else if ( ! $adminLogin && $user->groups->pluck('name')->search('Admin', true) !== false) 
        {
            \ErrorHandler::loginFailed();
        }
        else if ($user->blocked)
        {
            \ErrorHandler::userIsBlocked();
        }
        else if ($token = \JWTAuth::attempt($credentials))
        {
            return ['token' => $token];
        }
        else
        {
            \ErrorHandler::loginFailed();
        }
    }

    /**
     * Handle a social login request of the none admin to the application.
     * 
     * @param  array   $credentials
     * @return array
     */
    public function loginSocial($credentials)
    {
        $access_token = $credentials['auth_code'] ? \Socialite::driver($credentials['type'])->getAccessToken($credentials['auth_code']) : $credentials['access_token'];   
        $user         = \Socialite::driver($credentials['type'])->userFromToken($access_token);

        if ( ! $user->email)
        {
            \ErrorHandler::noSocialEmail();
        }

        if ( ! $registeredUser = $this->model->where('email', $user->email)->first()) 
        {
            $data = ['email' => $user->email, 'password' => ''];
            return $this->register($data);
        }
        else
        {
            if ( ! \Auth::attempt(['email' => $registeredUser->email, 'password' => '']))
            {
                \ErrorHandler::userAlreadyRegistered();
            }
            return $this->login(['email' => $registeredUser->email, 'password' => ''], false);
        }
    }
    
    /**
     * Handle a registration request.
     * 
     * @param  array $credentials
     * @return array
     */
    public function register($credentials)
    {
        return ['token' => \JWTAuth::fromUser($this->model->create($credentials))];
    }

    /**
     * Logout the user.
     * 
     * @return boolean
     */
    public function logout()
    {
        return \JWTAuth::invalidate(\JWTAuth::getToken());
    }

    /**
     * Block the user.
     *
     * @param  integer $user_id
     * @return object
     */
    public function block($user_id)
    {
        if ( ! $user = $this->find($user_id)) 
        {
            \ErrorHandler::notFound('user');
        }
        if ( ! $this->hasGroup('Admin'))
        {
            \ErrorHandler::noPermissions();
        }
        else if (\JWTAuth::parseToken()->authenticate()->id == $user_id)
        {
            \ErrorHandler::noPermissions();
        }
        else if ($user->groups->pluck('name')->search('Admin', true) !== false) 
        {
            \ErrorHandler::noPermissions();
        }

        $user->blocked = 1;
        $user->save();
        
        return $user;
    }

    /**
     * Unblock the user.
     *
     * @param  integer $user_id
     * @return object
     */
    public function unblock($user_id)
    {
        if ( ! $this->hasGroup('Admin'))
        {
            \ErrorHandler::noPermissions();
        }

        $user          = $this->find($user_id);
        $user->blocked = 0;
        $user->save();

        return $user;
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  string  $url
     * @param  string  $email
     * @return void
     */
    public function sendReset($email, $url)
    {
        view()->composer('auth.emails.password', function($view) use ($url) {
            $view->with(['url' => $url]);
        });

        $response = \Password::sendResetLink($email, function (\Illuminate\Mail\Message $message) {
            $message->subject('Your Password Reset Link');
        });

        switch ($response) 
        {
            case \Password::INVALID_USER:
                \ErrorHandler::notFound('email');
        }
    }

    /**
     * Reset the given user's password.
     *
     * @param  array  $credentials
     * @return array
     */
    public function resetPassword($credentials)
    {
        $token    = false;
        $response = \Password::reset($credentials, function ($user, $password) use (&$token) {
            $user->password = bcrypt($password);
            $user->save();

            $token = \JWTAuth::fromUser($user);
        });

        switch ($response) {
            case \Password::PASSWORD_RESET:
                return ['token' => $token];
                
            case \Password::INVALID_TOKEN:
                \ErrorHandler::invalidResetToken('token');

            case \Password::INVALID_PASSWORD:
                \ErrorHandler::invalidResetPassword('email');

            case \Password::INVALID_USER:
                \ErrorHandler::notFound('user');

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
        $user = $this->find(\JWTAuth::parseToken()->authenticate()->id, $relations);
        if ( ! \Hash::check($credentials['old_password'], $user->password)) 
        {
            \ErrorHandler::invalidOldPassword();
        }

        $user->password = $credentials['password'];
        $user->save();
    }

    /**
     * Refresh the expired login token.
     *
     * @return array
     */
    public function refreshtoken()
    {
        $token = \JWTAuth::parseToken()->refresh();

        return ['token' => $token];
    }
}
