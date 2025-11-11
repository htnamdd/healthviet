<?php

namespace Healthviet\Banner\Model;

use Healthviet\Banner\Model\Source\Banner\SectionType;
use Healthviet\Banner\Api\Request\BannerRequestInterface;

/**
 * Class BannerManagement
 * @package Healthviet\Banner\Model
 */
class BannerManagement implements \Healthviet\Banner\Api\BannerManagementInterface
{
    protected $bannerCollectionFactory;

    /**
     * @var \Healthviet\Banner\Helper\Data
     */
    protected $data;

    /**
     * BannerManagement constructor.
     * @param ResourceModel\Collection\Banner\FactoryCollection $bannerCollectionFactory
     */
    public function __construct(
        \Healthviet\Banner\Model\ResourceModel\Collection\Banner\FactoryCollection $bannerCollectionFactory,
        \Healthviet\Banner\Helper\Data $data
    )
    {
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        $this->data = $data;
    }

    /**
     * get List banner of slider
     * @param \Healthviet\Banner\Api\Request\BannerRequestInterface $params
     * @return \Healthviet\Banner\Api\Data\BannerInterface[]
     */
    public function getBySlider(BannerRequestInterface $params)
    {
        $collection = $this->bannerCollectionFactory
            ->setCollectionType(SectionType::LIST_BANNER_OF_SLIDER)
            ->setSliderCode($params->getSliderCode())
            ->createCollection();
        return $collection->getItems();
    }

    /**
     * get List banner of Agent and catId
     * @param \Healthviet\Banner\Api\Request\BannerRequestInterface $params
     * @return \Healthviet\Banner\Api\Data\BannerInterface[]
     */
    public function getByCategory(BannerRequestInterface $params)
    {
        $collection = $this->bannerCollectionFactory
            ->setCollectionType(SectionType::LIST_BANNER_OF_CAT_AND_AGENT)
            ->setCatId($params->getCatId())
            ->setDetailCatSliderAttributeCode('detail_category_slider')
            ->createCollection();
        return $collection->getItems();
    }

}
