<?php namespace App\Modules\Acl\Proxy;

use Illuminate\Foundation\Application;
use App\Modules\Acl\Repositories\UserRepository;

class LoginProxy
{
    private $apiConsumer;

    private $auth;

    private $request;

    private $userRepository;

    public function __construct(Application $app)
    {

        $this->userRepository = $app->make('App\Modules\Acl\Repositories\UserRepository');
        $this->apiConsumer    = $app->make('apiconsumer');
        $this->auth           = $app->make('auth');
        $this->request        = $app->make('request');
    }

    /**
     * Attempt to create an access token using user credentials.
     *
     * @param  array   $credentials
     * @param  boolean $adminLogin
     * @return array
     */
    public function login($credentials, $adminLogin = false)
    {
        $this->userRepository->login($credentials, $adminLogin);

        return $this->proxy('password', [
            'username' => $credentials['email'],
            'password' => $credentials['password']
        ]);
    }

    /**
     * Attempt to refresh the access token useing the given refresh token.
     *
     * @param  string $refreshToken
     * @return array
     */
    public function refreshtoken($refreshToken)
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

        $response = $this->apiConsumer->post('/oauth/token', $data);

        if (! $response->isSuccessful()) {
            if ($grantType == 'refresh_token') {
                \ErrorHandler::invalidRefreshToken();
            }

            \ErrorHandler::loginFailed();
        }

        $data = json_decode($response->getContent());

        return [
            'access_token'  => $data->access_token,
            'refresh_token' => $data->refresh_token,
            'expires_in'    => $data->expires_in
        ];
    }

    /**
     * Logs out the user. We revoke access token and refresh token.
     *
     * @return void
     */
    public function logout()
    {
        \Core::users()->revokeAccessToken($this->auth->user()->token());
    }
}
