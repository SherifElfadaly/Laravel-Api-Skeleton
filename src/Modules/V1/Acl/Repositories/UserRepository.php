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
        \Core::users()->find($user->id, ['groups.permissions'])->groups->lists('permissions')->each(function ($permission) use (&$permissions, $model){
            $permissions = array_merge($permissions, $permission->where('model', $model)->lists('name')->toArray()); 
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
        $groups = \Core::users()->find(\JWTAuth::parseToken()->authenticate()->id)->groups;
        return $groups->lists('name')->search($groupName, true) === false ? false : true;
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
            $user = \Core::users()->find($user_id);
            $user->groups()->detach();
            $user->groups()->attach($group_ids);
        });

        return \Core::users()->find($user_id);
    }

    /**
     * Handle a login request to the application.
     * 
     * @param  array   $credentials    
     * @param  boolean $adminLogin
     * @return string
     */
    public function login($credentials, $adminLogin = false)
    {
        if ( ! $user = \Core::users()->first(['email' => $credentials['email']])) 
        {
            \ErrorHandler::loginFailed();
        }
        else if ($adminLogin && $user->groups->lists('name')->search('Admin', true) === false) 
        {
            \ErrorHandler::loginFailed();
        }
        else if ( ! $adminLogin && $user->groups->lists('name')->search('Admin', true) !== false) 
        {
            \ErrorHandler::loginFailed();
        }
        else if ($user->blocked)
        {
            \ErrorHandler::userIsBlocked();
        }
        else if ($token = \JWTAuth::attempt($credentials))
        {
            return $token;
        }
        else
        {
            \ErrorHandler::loginFailed();
        }
    }

    /**
     * Handle a registration request.
     * 
     * @param  array $credentials
     * @return string
     */
    public function register($credentials)
    {
        return \JWTAuth::fromUser(\Core::users()->model->create($credentials));
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
        if ( ! $user = \Core::users()->find($user_id)) 
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
        else if ($user->groups->lists('name')->search('Admin', true) !== false) 
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

        $user          = \Core::users()->find($user_id);
        $user->blocked = 0;
        $user->save();

        return $user;
    }

    /**
     * Handle the editing of the user profile.
     * 
     * @param  array $profile
     * @return object
     */
    public function editProfile($profile)
    {
        unset($profile['email']);
        unset($profile['password']);
        $profile['id'] = \JWTAuth::parseToken()->authenticate()->id;
        
        return $this->save($profile);
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
     * @return integer
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
                return $token;
                
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
}
