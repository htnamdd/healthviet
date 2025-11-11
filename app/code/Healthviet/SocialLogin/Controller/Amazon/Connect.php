<?php
namespace Healthviet\SocialLogin\Controller\Amazon;

use Healthviet\SocialLogin\Controller\AbstractConnect;

class Connect extends AbstractConnect
{
    /**
     * @var string
     */
    protected $_exeptionMessage = 'Amazon login failed.';

    /**
     * @var string
     */
    protected $_type = 'amazon';

    /**
     * @var string
     */
    protected $_path = '/user/profile';

    /**
     * @var string
     */
    protected $clientModel = '\Healthviet\SocialLogin\Model\Amazon\Client';

    /**
     * @param $userInfo
     * @return array
     */
    public function getDataNeedSave($userInfo)
    {
        $dataParent = parent::getDataNeedSave($userInfo);
        $name = explode(' ', $userInfo['name'], 2);
        if (count($name) > 1) {
            $firstName = $name[0];
            $lastName = $name[1];
        } else {
            $firstName = $name[0];
            $lastName = $name[0];
        }
        $data = [
            'email' => $userInfo['email'],
            'firstname' => $firstName,
            'lastname' => $lastName,
        ];

        return array_replace_recursive($dataParent, $data);
    }
}
