<?php
namespace Healthviet\SocialLogin\Controller\Pinterest;

use Healthviet\SocialLogin\Controller\AbstractConnect;

class Connect extends AbstractConnect
{
    /**
     * @var string
     */
    protected $_exeptionMessage = 'Pinterest login failed.';

    /**
     * @var string
     */
    protected $_type = 'pinterest';

    /**
     * @var string
     */
    protected $_path = '/me';


    /**
     * @var string
     */
    protected $clientModel = '\Healthviet\SocialLogin\Model\Pinterest\Client';

    /**
     * @param $userInfo
     * @return array
     */
    public function getDataNeedSave($userInfo)
    {
        $dataParent = parent::getDataNeedSave($userInfo);

        $data = [
            'email' => $userInfo['email'],
            'firstname' => $userInfo['first_name'],
            'lastname' => $userInfo['last_name'],
        ];

        return array_replace_recursive($dataParent, $data);
    }
}
