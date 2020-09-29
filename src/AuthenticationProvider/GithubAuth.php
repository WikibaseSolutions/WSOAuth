<?php

namespace AuthenticationProvider;

use League\OAuth2\Client\Provider\Github;

/**
 * Class GithubAuth
 * @package AuthenticationProvider
 */
class GithubAuth implements \AuthProvider
{
    /**
     * @var Github
     */
    private $provider;

    /**
     * GithubAuth constructor.
     */
    public function __construct()
    {
        $this->provider = new Github([
            'clientId' => $GLOBALS['wgOAuthClientId'],
            'clientSecret' => $GLOBALS['wgOAuthClientSecret'],
            'redirectUri' => $GLOBALS['wgOAuthRedirectUri'],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function login(&$key, &$secret, &$auth_url)
    {
        $auth_url = $this->provider->getAuthorizationUrl([
            'scope' => []
        ]);

        $secret = $this->provider->getState();

        return true;
    }

    /**
     * @inheritDoc
     */
    public function logout(\User &$user)
    {
    }

    /**
     * @inheritDoc
     */
    public function getUser($key, $secret, &$errorMessage)
    {
        if (!isset($_GET['code'])) {
            return false;
        }

        if (!isset($_GET['state']) || empty($_GET['state']) || ($_GET['state'] !== $secret)) {
            return false;
        }

        try {
            $token = $this->provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);

            $user = $this->provider->getResourceOwner($token);

            return [
                'name' => $user->getNickname()
            ];
        } catch(\Exception $e) {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function saveExtraAttributes($id)
    {
    }
}
