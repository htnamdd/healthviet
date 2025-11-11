<?php

namespace Healthviet\Banner\Block;

use Magento\Widget\Block\BlockInterface;

class Banner extends \Magento\Catalog\Block\Product\AbstractProduct implements BlockInterface
{
    /**
     * @var \Healthviet\Banner\Model\ResourceModel\Collection\Banner\FactoryCollection
     */
    protected $bannerCollectionFactory;
    /**
     * DEFAULT_TEMPLATE
     */
    const DEFAULT_TEMPLATE = 'slide.phtml';
    /**
     * DEFAULT_PATH
     */
    const DEFAULT_PATH = 'Healthviet_Banner::block/';
    /**
     * DEFAULT_PATH_AJAX
     */
    const DEFAULT_PATH_AJAX = 'Healthviet_Banner::ajax/';

    /**
     * @var \Healthviet\Banner\Helper\Data
     */
    protected $dataHelper;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Healthviet\Banner\Model\ResourceModel\Collection\Banner\FactoryCollection $bannerCollectionFactory,
        \Healthviet\Banner\Helper\Data $dataHelper,
        array $data = []
    )
    {
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        $this->dataHelper = $dataHelper;
        parent::__construct($context, $data);
    }

    /**
     * @return array
     */
    private function loadParams()
    {
        $collection_type = $this->getConfig('section_type');
        $page_size = $this->getConfig('total_item');
        return [
            'slider_code' => $this->getConfig('slider_code'),
            'type' => $collection_type != '' ? $collection_type : \Healthviet\Banner\Model\Source\Banner\SectionType::STATIC_BANNER_SECTION,
            'page_num' => 1,
            'template' => $this->getConfig('layout_template'),
            'page_size' => $page_size != '' ? $page_size : \Healthviet\Banner\Helper\Data::DEFAULT_SECTION_ITEM
        ];
    }

    /**
     * @param $key
     * @param string $default
     * @return mixed|string
     */
    public function getConfig($key, $default = '')
    {
        if ($this->hasData($key)) {
            return $this->getData($key);
        }
        return $default;
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        $layout_template = $this->getConfig('layout_template');
        $path = self::DEFAULT_PATH;
        if ($this->getConfig('enable_ajax')) {
            $path = self::DEFAULT_PATH_AJAX;
        }
        $this->setTemplate($layout_template != '' ? $path . $layout_template : $path . self::DEFAULT_TEMPLATE);
        return parent::_toHtml();
    }

    /**
     * Get collection
     * @return mixed
     */
    public function getCollection()
    {
        $collection = $this->bannerCollectionFactory
            ->setParams($this->loadParams())
            ->createCollection();
        return $this->dataHelper->toArray($collection);
    }

}
