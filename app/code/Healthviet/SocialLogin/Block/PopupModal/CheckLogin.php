<?php

namespace Healthviet\SocialLogin\Block\PopupModal;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Framework\Url\DecoderInterface;
use Magento\Framework\Url\HostChecker;
use Magento\Framework\View\Element\Template;
use Magento\Customer\Model\Account\Redirect as AccountRedirect;
use Magento\Framework\View\Element\Template\Context;

class CheckLogin extends Template
{

    /**
     * @var \Magento\Framework\Url
     */
    protected $urlHelper;

    /**
     * @var DecoderInterface
     */
    protected $urlDecoder;

    /**
     * @var HostChecker
     */
    private $hostChecker;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @param Context $context
     * @param \Magento\Framework\Url $urlHelper
     * @param DecoderInterface $decoder
     * @param HostChecker $checker
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Url $urlHelper,
        DecoderInterface $decoder,
        HostChecker $checker,
        \Magento\Customer\Model\Session $customerSession
    )
    {
        $this->urlHelper        = $urlHelper;
        $this->urlDecoder       = $decoder;
        $this->hostChecker      = $checker;
        $this->_customerSession = $customerSession;
        parent::__construct($context);
    }

    /**
     * @return Bool
     */
    public function isUserLogin()
    {
        return $this->_customerSession->isLoggedIn();
    }

    /**
     * @return String
     */
    public function getSignInUrl()
    {
        return $this->urlHelper->getUrl('customer/account/login/');
    }

    /**
     * Get account redirect.
     * For release backward compatibility.
     *
     * @return AccountRedirect
     */
    protected function getAccountRedirect()
    {
        return ObjectManager::getInstance()->get(AccountRedirect::class);
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        $redirectRoute     = $this->getAccountRedirect()->getRedirectCookie();
        $redirectDashboard = (bool)$this->getScopeConfig()->getValue(CustomerUrl::XML_PATH_CUSTOMER_STARTUP_REDIRECT_TO_DASHBOARD);
        if ($redirectDashboard) {
            return $this->getBaseUrl();
        } else if (!$redirectDashboard && $redirectRoute) {
            $this->getAccountRedirect()->clearRedirectCookie();
            return $this->getRedirectResult()->success($redirectRoute);
        } else {
            return $this->getReferer();
        }
    }

    /**
     * @return ScopeConfigInterface
     */
    private function getScopeConfig()
    {
        return ObjectManager::getInstance()->get(ScopeConfigInterface::class);
    }

    /**
     * @return \Magento\Framework\App\Response\RedirectInterface
     */
    private function getRedirectResult()
    {
        return ObjectManager::getInstance()->get(\Magento\Framework\App\Response\RedirectInterface::class);
    }

    /**
     * @return null|string
     */
    private function getReferer()
    {
        $referer = $this->_session->getRefererParam();
        if ($referer) {
            $referer = $this->urlDecoder->decode($referer);
            if ($this->hostChecker->isOwnOrigin($referer)) {
                return $referer;
            }
        }
        return null;
    }
}
