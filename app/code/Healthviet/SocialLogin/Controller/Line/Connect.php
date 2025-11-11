<?php
namespace Healthviet\SocialLogin\Controller\Line;

use Healthviet\SocialLogin\Controller\AbstractConnect;

class Connect extends AbstractConnect
{
    /**
     * @var string
     */
    protected $_exeptionMessage = 'Line login failed.';

    /**
     * @var string
     */
    protected $_type = 'line';

    /**
     * @var string
     */
    protected $_path = '/v1/profile';

    /**
     * @var string
     */
    protected $clientModel = '\Healthviet\SocialLogin\Model\Line\Client';

    /**
     * @param $userInfo
     * @return array
     */
    public function getDataNeedSave($userInfo)
    {
        $dataParent = parent::getDataNeedSave($userInfo);
        $userName = explode(" ", $userInfo['displayName']);
        $data = [
            'email' => $userInfo['email'],
            'firstname' => $userName[0],
            'lastname' => $userName[1],
        ];

        return array_replace_recursive($dataParent, $data);
    }
}
