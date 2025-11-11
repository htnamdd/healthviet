<?php
namespace Healthviet\SocialLogin\Model\Line;

use Healthviet\SocialLogin\Model\AbstractClient;
use Magento\Framework\Exception\LocalizedException;

class Client extends AbstractClient
{
    protected $redirect_uri_path = 'sociallogin/line/connect';
    protected $path_enalbed = 'healthviet/line/enabled';
    protected $path_client_id = 'healthviet/line/client_id';
    protected $path_client_secret = 'healthviet/line/client_secret';
    protected $oauth2_service_uri = 'https://api.line.me';
    protected $oauth2_auth_uri = 'https://access.line.me/dialog/oauth/weblogin';
    protected $oauth2_token_uri = 'https://api.line.me/v1/oauth/accessToken';
    protected $scope = [
        'profile'
    ];

    public function createAuthUrl()
    {
        $query = [
            'response_type' => 'code',
            'client_id' => $this->getClientId(),
            'redirect_uri' => $this->getRedirectUri(),
            'state' => 'Blahblah'
//            'access_type' => 'offline',
//            'approval_prompt' => 'auto'
        ];
        $url = $this->oauth2_auth_uri . '?' . http_build_query($query);
        return $url;
    }

    public function api($endpoint, $code, $method = 'GET', $params = [])
    {
        if (empty($this->token)) {
            $this->fetchAccessToken($code);
        }
        $url = $this->oauth2_service_uri . $endpoint;
        $headers = ['Authorization' => 'Bearer ' . $this->token];
        $response = $this->_httpRequest($url, $method, $params, $headers);
        return $response;
    }

    protected function fetchAccessToken($code = null)
    {
        $token_array = [
            'grant_type' => 'authorization_code',
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'code' => $code,
            'redirect_uri' => $this->getRedirectUri(),
        ];
        if (empty($code)) {
            throw new LocalizedException(
                __('Unable to retrieve access code.')
            );
        }
        $response = $this->_httpRequest(
            'https://api.line.me/v1/oauth/accessToken',
            'POST',
            $token_array
        );
        $this->setAccessToken($response['access_token']);
        return $this->getAccessToken();
    }
}
