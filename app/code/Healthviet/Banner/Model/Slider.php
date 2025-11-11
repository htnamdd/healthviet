<?php


namespace Healthviet\Banner\Model;

use Magento\Framework\Api\DataObjectHelper;
use Healthviet\Banner\Api\Data\SliderInterface;
use Healthviet\Banner\Api\Data\SliderInterfaceFactory;

class Slider extends \Magento\Framework\Model\AbstractModel
{

    protected $sliderDataFactory;

    protected $_eventPrefix = 'healthviet_banner_slider';
    protected $dataObjectHelper;


    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param SliderInterfaceFactory $sliderDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Healthviet\Banner\Model\ResourceModel\Slider $resource
     * @param \Healthviet\Banner\Model\ResourceModel\Slider\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        SliderInterfaceFactory $sliderDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Healthviet\Banner\Model\ResourceModel\Slider $resource,
        \Healthviet\Banner\Model\ResourceModel\Slider\Collection $resourceCollection,
        array $data = []
    ) {
        $this->sliderDataFactory = $sliderDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve slider model with slider data
     * @return SliderInterface
     */
    public function getDataModel()
    {
        $sliderData = $this->getData();

        $sliderDataObject = $this->sliderDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $sliderDataObject,
            $sliderData,
            SliderInterface::class
        );

        return $sliderDataObject;
    }
}
