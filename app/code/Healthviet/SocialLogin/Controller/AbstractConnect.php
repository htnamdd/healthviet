<?php

namespace Healthviet\SocialLogin\Controller;

use Magento\Framework\App\Filesystem\DirectoryList;
use PHPUnit\Framework\Exception;

abstract class AbstractConnect extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Healthviet\SocialLogin\Helper\SocialLogin
     */
    protected $_helper;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var string
     */
    protected $clientModel;

    /**
     * @var string
     */
    protected $_type;

    /**
     * @var string
     */
    protected $_path;

    /**
     * @var string
     */
    protected $_exeptionMessage;

    protected $_profilePicture = [];

    /**
     * @var \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory
     */
    private $cookieMetadataFactory;

    /**
     * @var \Magento\Framework\Stdlib\Cookie\PhpCookieManager
     */
    private $cookieMetadataManager;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Healthviet\SocialLogin\Helper\SocialLogin $helperGoogle
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Healthviet\SocialLogin\Helper\SocialLogin $helperGoogle
    ) {
        $this->_customerSession = $customerSession;
        $this->_helper          = $helperGoogle;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        try {
            $this->connect();
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('sociallogin/checklogin/index');
        return $resultRedirect;
    }

    protected function connect()
    {
        $error = $this->getRequest()->getParam('error');
        $code  = $this->getRequest()->getParam('code');
        $state = $this->getRequest()->getParam('state');

        if (!(isset($error) || isset($code)) && !isset($state)) {
            return;
        }

        $client = $this->_objectManager->create($this->clientModel);
        if ($code) {
            $userInfo = $client->api($this->_path, $code);

            if (isset($userInfo['data'])) {
                $userInfo = $userInfo['data'];
            }

            if (isset($userInfo['user_id'])) {
                $userInfo['id'] = $userInfo['user_id'];
            }

            if (isset($userInfo['mid'])) {
                $userInfo['id'] = $userInfo['mid'];
            }

            if (!isset($userInfo['email']) || !isset($userInfo['id']))
                throw new \Exception(__('Không thể lấy được email, vui lòng cập nhật email ở tài khoản liên kết của bạn.'));
            /** Find a customer with Google Id */
            $customer = $this->_helper->getCustomers($userInfo['id'], $this->_type);
            if ($customer->getId()) {
                $customerRepo = $this->_helper->saveCustomerCustomerAttribute($customer, $customer->getProfilePicture() ? [] : $this->getProfilePicture($userInfo));
                if ($customerRepo) {
                    $this->_customerSession->setCustomerDataAsLoggedIn($customerRepo);
                    $this->_customerSession->regenerateId();
                    if ($this->getCookieManager()->getCookie('mage-cache-sessid')) {
                        $metadata = $this->getCookieMetadataFactory()->createCookieMetadata();
                        $metadata->setPath('/');
                        $this->getCookieManager()->deleteCookie('mage-cache-sessid', $metadata);
                    }
                }
                return;
            }
            /** Find a customer with Google Email */
            $customer = $this->_helper->getCustomerByEmail($userInfo['email']);
            if ($customer->getId()) {
                $data = array_merge(
                    [
                        'healthviet_sociallogin_id' => $userInfo['id'],
                        'healthviet_sociallogin_type' => $this->_type
                    ],
                    $this->getProfilePicture($userInfo)
                );
                $this->_helper->login($customer, $data);

                return;
            }
            /**
             * If don't exist customer, create new customer with this information
             *
             */
            $data = array_merge(
                $this->getDataNeedSave($userInfo),
                $this->getProfilePicture($userInfo)
            );
            $this->_helper->creatingAccount($data);
            return;
        }
    }

    /**
     * @param $data
     * @return array
     */
    protected function getProfilePicture($data)
    {
        if (isset($this->_profilePicture['link'])) {
            try {
                $picture                            = @file_get_contents($this->_profilePicture['link']);
                $filePath                           = $this->_objectManager->get(\Magento\Framework\Filesystem::class)->getDirectoryWrite(DirectoryList::MEDIA)->getAbsolutePath('customer/avatar/tmp');
                $this->_profilePicture['file_name'] = $this->_type . '_' . $data['id'] . $this->_profilePicture['extension'];
                $result                             = @file_put_contents($filePath . '/' . $this->_profilePicture['file_name'], $picture);
                if ($result) {
                    return [
                        'profile_picture' => 'avatar/' . $this->_profilePicture['file_name']
                    ];
                }
            } catch (Exception $exception) {
                $this->_objectManager->get(\Psr\Log\LoggerInterface::class)->debug($exception->getMessage());
                return [];
            }
        }
        return [];
    }

    /**
     * Save Information
     *
     * @param $userInfo
     * @return array
     */
    public function getDataNeedSave($userInfo)
    {
        $data = [
            'sendemail' => 0,
            'confirmation' => 0,
            'healthviet_sociallogin_id' => $userInfo['id'],
            'healthviet_sociallogin_type' => $this->_type
        ];

        return $data;
    }

    /**
     * Retrieve cookie manager
     *
     * @deprecated 100.1.0
     * @return \Magento\Framework\Stdlib\Cookie\PhpCookieManager
     */
    private function getCookieManager()
    {
        if (!$this->cookieMetadataManager) {
            $this->cookieMetadataManager = \Magento\Framework\App\ObjectManager::getInstance()->get(
                \Magento\Framework\Stdlib\Cookie\PhpCookieManager::class
            );
        }
        return $this->cookieMetadataManager;
    }

    /**
     * Retrieve cookie metadata factory
     *
     * @deprecated 100.1.0
     * @return \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory
     */
    private function getCookieMetadataFactory()
    {
        if (!$this->cookieMetadataFactory) {
            $this->cookieMetadataFactory = \Magento\Framework\App\ObjectManager::getInstance()->get(
                \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory::class
            );
        }
        return $this->cookieMetadataFactory;
    }
}
