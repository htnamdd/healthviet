<?php


namespace Healthviet\Banner\Model\ResourceModel\Banner\Collection;


class BannerOfCatAndAgent extends \Healthviet\Banner\Model\ResourceModel\Collection\Banner\AbstractCollection
{
    protected $categoryFactory;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Healthviet\Banner\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory
    )
    {
        parent::__construct($context, $bannerCollectionFactory);
        $this->categoryFactory = $categoryFactory;
    }

    public function createCollection()
    {
        $category=$this->categoryFactory->create()->load($this->params['cat_id']);
        $detailSliderForWeb=$category->getCustomAttribute($this->params['detail_cat_slider_attribute_code']);
        $sliderId= $detailSliderForWeb && $detailSliderForWeb->getValue() ? $detailSliderForWeb->getValue():-1;
        $collection = $this->bannerCollectionFactory->create();
        $collection->addFieldToFilter('slider_id', $sliderId);
        return $collection;
    }
}
