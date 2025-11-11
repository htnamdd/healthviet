<?php
namespace Healthviet\SocialLogin\Model\Share;

use Magento\Backend\App\ConfigInterface;
use Magento\Framework\DataObject;

class Share extends DataObject
{
    const XML_PATH_ENABLED = 'healthviet/share/enabled';
    protected $_config;

    public function __construct(
        ConfigInterface $config,
        array $data = array()
    ) {
        $this->_config = $config;
        parent::__construct($data);
    }

    public function isEnabled()
    {

        return (bool)$this->_isEnabled();
    }

    protected function _isEnabled()
    {
        return $this->_getStoreConfig(self::XML_PATH_ENABLED);
    }


    protected function _getStoreConfig($xmlPath)
    {
        return $this->_config->getValue($xmlPath);
    }
}
