<?php

namespace Healthviet\Banner\Model\ResourceModel\Collection\Banner;

class FactoryCollection
{
    const CACHE_TAG = 'banner_c';
    protected $location;
    protected $objectManager;
    protected $eventManager;
    protected $params = [];
    protected $sliderCode;
    protected $agent;
    protected $catId;
    protected $collectionType;
    protected $detailCatSliderAttributeCode;

    public function __construct
    (
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Event\ManagerInterface $eventManager
    )
    {
        $this->objectManager = $objectManager;
        $this->eventManager = $eventManager;
    }

    public function createCollection()
    {
        $collection = $this->objectManager->create(\Healthviet\Banner\Model\Source\Banner\SectionType::arrCollectionClass[$this->params['type']]);
        $collection = $collection->setParams($this->params)->createCollection();
        if (count($collection)) {
            $this->eventManager->dispatch('banner_collection_load_after', ['collection' => $collection]);
        }

        return $collection;
    }

    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    public function setSliderCode($sliderCode)
    {
        $this->params['slider_code'] = $sliderCode;
        $this->sliderCode = $sliderCode;
        return $this;
    }

    public function setCatId($catId)
    {
        $this->params['cat_id'] = $catId;
        $this->catId = $catId;
        return $this;
    }

    public function setAgentId($agent)
    {
        $this->params['agent'] = $agent;
        $this->agent = $agent;
        return $this;
    }

    public function setCollectionType($collectionType)
    {
        $this->params['type'] = $collectionType;
        $this->collectionType = $collectionType;
        return $this;
    }

    public function setDetailCatSliderAttributeCode($detailCatSliderAttributeCode)
    {
        $this->params['detail_cat_slider_attribute_code'] = $detailCatSliderAttributeCode;
        $this->detailCatSliderAttributeCode = $detailCatSliderAttributeCode;
        return $this;
    }
}
