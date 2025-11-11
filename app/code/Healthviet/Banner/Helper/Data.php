<?php

namespace Healthviet\Banner\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Data extends AbstractHelper
{
    const DEFAULT_SECTION_ITEM = 8;
    const IMAGE_SUFFIX_PATH = 'button/image/';
    /**
     * @var \Healthviet\Common\Helper\Config
     */
    protected $configHelper;

    /**
     * @var \Magento\Backend\Model\UrlInterface
     */
    protected $backendUrl;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    public function __construct(
        \Healthviet\Common\Helper\Config $configHelper,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        Context $context
    ) {
        $this->configHelper = $configHelper;
        $this->backendUrl = $backendUrl;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * @param \Healthviet\Banner\Model\ResourceModel\Banner\Collection
     * @return array
     */
    public function toArray($banners)
    {
        $res = [];
        foreach ($banners as $banner) {
            $res [] = [
                'title' => $banner->getTitle(),
                'subtitle' => $banner->getSubtitle(),
                'show_title' => $banner->getShowTitle(),
                'url_redirect' => $banner->getUrlRedirect(),
                'target' => $banner->getTarget(),
                'image' => $banner->getImage() ? $this->configHelper->getBaseMediaUrl() . $banner->getImage() : '',
                'mobile_image' => $banner->getMobileImage() ? $this->configHelper->getBaseMediaUrl() . $banner->getMobileImage() : '',
                'alt_text' => $banner->getTitle(),
                'sort_order' => $banner->getSortOrder(),
            ];
        }
        return $res;
    }

    /**
     * get Slider Banner Url
     * @return string
     */
    public function getSliderBannerUrl()
    {
        return $this->backendUrl->getUrl('*/*/banners', ['_current' => true]);
    }
}
