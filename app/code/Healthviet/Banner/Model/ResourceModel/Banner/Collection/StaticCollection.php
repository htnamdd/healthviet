<?php

namespace Healthviet\Banner\Model\ResourceModel\Banner\Collection;

class StaticCollection extends \Healthviet\Banner\Model\ResourceModel\Collection\Banner\AbstractCollection
{
    protected $sliderCollectionFactory;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Healthviet\Banner\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,
        \Healthviet\Banner\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory
    )
    {
        parent::__construct($context, $bannerCollectionFactory);
        $this->sliderCollectionFactory = $sliderCollectionFactory;
    }

    public function createCollection()
    {
        $slider = $this->sliderCollectionFactory->create()
            ->addFieldToFilter('slider_code', ['eq' => $this->params['slider_code']])
            ->getFirstItem();
        $sliderId = $slider ? $slider->getSliderId() : 0;
        $bannerCollection = $this->bannerCollectionFactory->create()
            ->addFieldToFilter('slider_id', ['eq' => $sliderId])
            ->addFieldToFilter('enable', ['eq' => \Healthviet\Banner\Model\Source\Banner\SliderCode::ENABLE])
            ->setOrder('sort_order', 'asc');
        return $bannerCollection;
    }
}
