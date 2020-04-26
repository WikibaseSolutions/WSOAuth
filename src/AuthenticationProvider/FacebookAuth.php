<?php

/**
 * Copyright 2020 Marijn van Wezel
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE
 * OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace AuthenticationProvider;

/**
 * Class FacebookAuth
 * @package AuthenticationProvider
 */
class FacebookAuth implements \AuthProvider
{
    /**
     * @var \League\OAuth2\Client\Provider\Facebook
     */
    private $provider;

    public function __construct()
    {
        $this->provider = new \League\OAuth2\Client\Provider\Facebook([
            'clientId' => $GLOBALS['wgOAuthClientId'],
            'clientSecret' => $GLOBALS['wgOAuthClientSecret'],
            'redirectUri' => $GLOBALS['wgOAuthRedirectUri'],
            'graphApiVersion' => 'v6.0'
        ]);
    }

    /**
     * @inheritDoc
     */
    public function login(&$key, &$secret, &$auth_url)
    {
        $auth_url = $this->provider->getAuthorizationUrl([
            'scope' => ['email']
        ]);

        $secret = $this->provider->getState();
    }

    /**
     * @inheritDoc
     */
    public function logout(\User &$user)
    {
    }

    /**
     * @inheritDoc
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function getUser($key, $secret, &$errorMessage)
    {
        if (!isset($_GET['code'])) {
            return false;
        }

        if (!isset($_GET['state']) || empty($_GET['state']) || ($_GET['state'] !== $secret)) {
            return false;
        }

        $token = $this->provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);

        $user = $this->provider->getResourceOwner($token);

        return [
            'name' => $user->getId(),
            'realname' => $user->getName(),
            'email' => $user->getEmail()
        ];
    }

    /**
     * @inheritDoc
     */
    public function saveExtraAttributes($id)
    {
    }
}