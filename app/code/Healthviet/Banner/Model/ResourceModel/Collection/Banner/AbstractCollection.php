<?php


namespace Healthviet\Banner\Model\ResourceModel\Collection\Banner;


class AbstractCollection extends \Magento\Catalog\Model\ResourceModel\Collection\AbstractCollection
{
    protected $context;
    /**
     * @var $params
     */
    protected $params;
    /**
     * Product collection factory
     *
     * @var \Healthviet\Banner\Model\ResourceModel\Banner\CollectionFactory
     */
    protected $bannerCollectionFactory;


    /**
     * ProductCollectionAbstract constructor.
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Healthviet\Banner\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Healthviet\Banner\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory
    )
    {
        $this->context = $context;
        $this->bannerCollectionFactory = $bannerCollectionFactory;
    }

    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }
}
