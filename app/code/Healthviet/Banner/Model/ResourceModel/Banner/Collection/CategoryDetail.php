<?php


namespace Healthviet\Banner\Model\ResourceModel\Banner\Collection;


class CategoryDetail extends \Healthviet\Banner\Model\ResourceModel\Collection\Banner\AbstractCollection
{
    protected $registry;
    protected $categoryFactory;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Healthviet\Banner\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory
    )
    {
        parent::__construct($context, $bannerCollectionFactory);
        $this->registry = $registry;
        $this->categoryFactory = $categoryFactory;
    }

    public function createCollection()
    {
        $currentCategory = $this->registry->registry('current_category');
        $detailSliderAttribute = $currentCategory->getCustomAttribute('detail_category_slider');
        $sliderId = $detailSliderAttribute ? $detailSliderAttribute->getValue() : 0;
        $collection = $this->bannerCollectionFactory->create();
        $collection->addFieldToFilter('slider_id', $sliderId);
        return $collection;
    }
}
