<?php
namespace Healthviet\SocialLogin\Model\Reddit;

use Healthviet\SocialLogin\Model\AbstractClient;
use Magento\Framework\Exception\LocalizedException;

class Client extends AbstractClient
{
    protected $redirect_uri_path = 'sociallogin/reddit/connect';
    protected $path_enalbed='healthviet/reddit/enabled';
    protected $path_client_id ='healthviet/reddit/client_id';
    protected $path_client_secret='healthviet/reddit/client_secret';
    protected $oauth2_service_uri= 'https://www.reddit.com/api/v1';
    protected $oauth2_auth_uri ='https://www.reddit.com/api/v1/authorize';
    protected $oauth2_token_uri = 'https://www.reddit.com/api/v1/access_token';
    protected $scope = [
        'identity'
    ];

    public function createAuthUrl()
    {
        $query = [
            'client_id' => $this->getClientId(),
            'response_type' => 'code',
            'state' => 'access',
            'redirect_uri' => $this->getRedirectUri(),
            'duration' => 'temporary',
            'scope' => implode(' ', $this->getScope()),
//            'access_type' => 'offline',
//            'approval_prompt' => 'auto'
        ];
        $url = $this->oauth2_auth_uri . '?' . http_build_query($query);
        return $url;
    }

    protected function fetchAccessToken($code = null) {
        $token_array = [
        'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $this->getRedirectUri() ];
        if (empty($code)) {
            throw new LocalizedException( __('Unable to retrieve access code.') );
        }
        $headers = ['Authorization'=>'Basic '.base64_encode($this->getClientId().':'.$this->getClientSecret())];
        $response = $this->_httpRequest(
            $this->oauth2_token_uri,
            'POST', $token_array,
            $headers );
        $this->setAccessToken($response['access_token']);
        return $this->getAccessToken();
    }
}
