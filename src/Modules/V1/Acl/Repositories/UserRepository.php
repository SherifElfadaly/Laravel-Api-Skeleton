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
     * @param  array $credentials    
     * @return string
     */
    public function login($credentials)
    {
        if ($this->isBlocked($credentials['email'])) 
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
        if ( ! $this->hasGroup('Admin'))
        {
            \ErrorHandler::noPermissions();
        }

        $user          = \Core::users()->find($user_id);
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
     * Check if the user blocked or not.
     *
     * @param  string $email
     * @return boolean
     */
    public function isBlocked($email)
    {
        $user = \Core::users()->first(['email' => $email]);
        if ( ! $user) 
        {
            \ErrorHandler::notFound('email or password');
        }

        return $user->blocked;
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
}
