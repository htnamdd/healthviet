<?php
namespace Healthviet\SocialLogin\Block\SocialNetwork;

class Reddit extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Healthviet\SocialLogin\Model\Google\Client
     */
    protected $_clientReddit;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Healthviet\SocialLogin\Model\Reddit\Client $clientReddit
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Healthviet\SocialLogin\Model\Reddit\Client $clientReddit
    ) {
        $this->_clientReddit = $clientReddit;
        parent::__construct($context);
    }

    /**
     * @return parent::_construct
     */
    protected function _construct()
    {
        parent::_construct();
    }

    /**
     * @return string
     */
    public function getButtonUrl()
    {
        return $this->_clientReddit->createAuthUrl();
    }

    /**
     * @return bool
     */
    public function isRedditEnabled()
    {
        return $this->_clientReddit->isEnabled();
    }
}
