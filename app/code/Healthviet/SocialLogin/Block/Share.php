<?php
namespace Healthviet\SocialLogin\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Share extends Template
{
    /**
     * @var \Healthviet\SocialLogin\Model\Share\Share
     */
    protected $_clientShare;

    /**
     * @param Context $context
     * @param \Healthviet\SocialLogin\Model\Share\Share $clientShare
     */
    public function __construct(
        Context $context,
        \Healthviet\SocialLogin\Model\Share\Share $clientShare
    ) {
        $this->_clientShare = $clientShare;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    public function isShareEnabled()
    {
        return $this->_clientShare->isEnabled();
    }
}
