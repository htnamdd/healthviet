<?php

namespace Healthviet\Banner\Block\Adminhtml\Banner\Helper\Renderer;

class MobileImage extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * Store manager.
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Banner factory.
     *
     * @var \Healthviet\Banner\Model\BannerFactory
     */
    protected $_bannerFactory;

    /**
     * [__construct description].
     *
     * @param \Magento\Backend\Block\Context                    $context
     * @param \Magento\Store\Model\StoreManagerInterface        $storeManager
     * @param \Healthviet\Banner\Model\BannerFactory  $bannerFactory
     * @param array                                             $data
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Healthviet\Banner\Model\BannerFactory $bannerFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->_storeManager  = $storeManager;
        $this->_bannerFactory = $bannerFactory;
    }

    /**
     * Render action.
     *
     * @param \Magento\Framework\DataObject $row
     *
     * @return string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        $banner = $this->_bannerFactory->create()->load($row->getId());

        $imageSrc = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)
            . $banner->getMobileImage();

        return '<image width="150" src ="' . $imageSrc . '" alt="' . $banner->getMobileImage() . '" >';
    }
}
