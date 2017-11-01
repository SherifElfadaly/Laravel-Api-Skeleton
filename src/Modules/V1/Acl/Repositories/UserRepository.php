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
     * @param  integer $userId
     * @return boolean
     */
    public function hasGroup($groupName, $userId = false)
    {
        $userId = $userId ?: \JWTAuth::parseToken()->authenticate()->id;
        $groups = $this->find($userId)->groups;
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
     * @param  string  $email
     * @return void
     */
    public function sendReset($email)
    {
        if ( ! $user = $this->model->where('email', $email)->first())
        {
            \ErrorHandler::notFound('email');
        }

        $url   = $this->config['resetLink'];
        $token = \Password::getRepository()->create($user);
        
        \Mail::send('acl::resetpassword', ['user' => $user, 'url' => $url, 'token' => $token], function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject('Your Password Reset Link');
        });
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
            $user->password = $password;
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
        $user = \JWTAuth::parseToken()->authenticate();
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
        $model      = call_user_func_array("{$this->getModel()}::with", array($relations));

        $model->whereHas('groups', function($q) use ($groupName){
            $q->where('name', $groupName);
        });

        
        if (count($conditions['conditionValues']))
        {
            $model->whereRaw($conditions['conditionString'], $conditions['conditionValues']);
        }

        if ($perPage) 
        {
            return $model->orderBy($sortBy, $sort)->paginate($perPage);
        }

        return $model->orderBy($sortBy, $sort)->get();
    }

    /**
     * Save the given data to the logged in user.
     *
     * @param  array $credentials
     * @return object
     */
    public function saveProfile($credentials) 
    {
        $user = \JWTAuth::parseToken()->authenticate();
        $user->save($credentials);

        return $user;
    }
}
