<?php
namespace Healthviet\SocialLogin\Controller\Instagram;

use Healthviet\SocialLogin\Controller\AbstractConnect;

class Connect extends AbstractConnect
{
    /**
     * @var string
     */
    protected $_exeptionMessage = 'Instagram login failed.';

    /**
     * @var string
     */
    protected $_type = 'instagram';

    /**
     * @var string
     */
    protected $_path = '/users/self/?access_token=';

    /**
     * @var string
     */
    protected $clientModel = '\Healthviet\SocialLogin\Model\Instagram\Client';

    /**
     * @param $userInfo
     * @return array
     */
    public function getDataNeedSave($userInfo)
    {
        $dataParent = parent::getDataNeedSave($userInfo);

        $data = [
            'email' => $userInfo['email'],
            'firstname' => $userInfo['full_name'],
            'lastname' => $userInfo['full_name'],
        ];

        return array_replace_recursive($dataParent, $data);
    }
}
