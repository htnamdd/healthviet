<?php
namespace Healthviet\SocialLogin\Block\PopupModal;

class LoginButton extends \Magento\Framework\View\Element\Template
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context
    )
    {
        parent::__construct($context);

    }

    /**
     * @return  Bool
     */
    public function isUserLogin(){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');
        if($customerSession->isLoggedIn()) {
            return 1;
        } else {
            return 0;
        }
    }

}
