<?php
namespace Healthviet\SocialLogin\Block\SocialNetwork;

class Pinterest extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Healthviet\SocialLogin\Model\Pinterest\Client
     */
    protected $_clientPinterest;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Healthviet\SocialLogin\Model\Pinterest\Client $clientPinterest
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Healthviet\SocialLogin\Model\Pinterest\Client $clientPinterest
    ) {
        $this->_clientPinterest = $clientPinterest;
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
        return $this->_clientPinterest->createAuthUrl();
    }

    /**
     * @return bool
     */
    public function isPinterestEnabled()
    {
        return $this->_clientPinterest->isEnabled();
    }
}
