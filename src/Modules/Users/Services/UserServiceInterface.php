<?php

namespace App\Modules\Users\Services;

use App\Modules\Core\BaseClasses\Contracts\BaseServiceInterface;
use Illuminate\Database\Eloquent\Model;

interface UserServiceInterface extends BaseServiceInterface
{
    /**
     * Return the logged in user account.
     *
     * @param  array   $relations
     * @return Model
     */
    public function account(array $relations = ['roles.permissions']): Model;

    /**
     * Check if the logged in user or the given user
     * has the given permissions on the given model.
     *
     * @param  string $permissionName
     * @param  string $model
     * @param  int    $userId
     * @return bool
     */
    public function can(string $permissionName, string $model, int $userId = 0): bool;

    /**
     * Check if the logged in or the given user has the given role.
     *
     * @param  array $roles
     * @param  int   $user
     * @return bool
     */
    public function hasRoles(array $roles, int $user = 0): bool;

    /**
     * Assign the given role ids to the given user.
     *
     * @param  int   $userId
     * @param  array $roleIds
     * @return Model
     */
    public function assignRoles(int $userId, array $roleIds): Model;

    /**
     * Handle the login request to the application.
     *
     * @param  string  $email
     * @param  string  $password
     * @return array
     */
    public function login(string $email, string $password): array;

    /**
     * Handle the social login request to the application.
     *
     * @param  string $authCode
     * @param  string $accessToken
     * @param  string $type
     * @return array
     */
    public function loginSocial(string $authCode, string $accessToken, string $type): array;

    /**
     * Handle the registration request.
     *
     * @param  array $data
     * @param  bool  $skipConfirmEmail
     * @param  int   $roleId
     * @return Model
     */
    public function register(array $data, bool $skipConfirmEmail = false, int $roleId = 0): Model;

    /**
     * Block the user.
     *
     * @param  int $userId
     * @return Model
     */
    public function block(int $userId): Model;

    /**
     * Unblock the user.
     *
     * @param  int $userId
     * @return Model
     */
    public function unblock(int $userId): Model;

    /**
     * Send a reset link to the given user.
     *
     * @param  string  $email
     * @return bool
     */
    public function sendReset(string $email): bool;

    /**
     * Reset the given user's password.
     *
     * @param   string  $email
     * @param   string  $password
     * @param   string  $passwordConfirmation
     * @param   string  $token
     * @return string
     */
    public function resetPassword(string $email, string $password, string $passwordConfirmation, string $token): string;

    /**
     * Change the logged in user password.
     *
     * @param  string  $password
     * @param  string  $oldPassword
     * @return bool
     */
    public function changePassword(string $password, string $oldPassword): bool;

    /**
     * Confirm email using the confirmation code.
     *
     * @param  string $confirmationCode
     * @return bool
     */
    public function confirmEmail(string $confirmationCode): bool;

    /**
     * Send the confirmation mail.
     *
     * @param  string $email
     * @return bool
     */
    public function sendConfirmationEmail(string $email): bool;

    /**
     * Save the given data to the logged in user.
     *
     * @param  array $data
     * @return Model
     */
    public function saveProfile(array $data): Model;

    /**
     * Logs out the user, revoke access token and refresh token.
     *
     * @return bool
     */
    public function logout(): bool;

    /**
     * Attempt to refresh the access token using the given refresh token.
     *
     * @param  string $refreshToken
     * @return array
     */
    public function refreshToken(string $refreshToken): array;
}
