<?php

namespace App\Modules\Users\Proxy;

use App\Modules\Users\Services\UserService;
use App\Modules\OauthClients\Services\OauthClientService;

class LoginProxy
{
    /**
     * Attempt to create an access token using user credentials.
     *
     * @param  string  $email
     * @param  string  $password
     * @return array
     */
    public function login($email, $password)
    {
        return $this->proxy('password', [
            'username' => $email,
            'password' => $password
        ]);
    }

    /**
     * Attempt to refresh the access token using the given refresh token.
     *
     * @param  string $refreshToken
     * @return array
     */
    public function refreshToken($refreshToken)
    {
        return $this->proxy('refresh_token', [
            'refresh_token' => $refreshToken
        ]);
    }

    /**
     * Proxy a request to the OAuth server.
     *
     * @param string $grantType what type of grant type should be proxied
     * @param array
     */
    public function proxy($grantType, array $data = [])
    {
        $data = array_merge($data, [
            'client_id'     => config('skeleton.passport_client_id'),
            'client_secret' => config('skeleton.passport_client_secret'),
            'grant_type'    => $grantType
        ]);

        $response = \ApiConsumer::post('/oauth/token', $data);

        if (! $response->isSuccessful()) {
            if ($grantType == 'refresh_token') {
                \Errors::invalidRefreshToken();
            }

            \Errors::loginFailed();
        }

        $data = json_decode($response->getContent());

        return [
            'access_token'  => $data->access_token,
            'refresh_token' => $data->refresh_token,
            'expires_in'    => $data->expires_in
        ];
    }
}
