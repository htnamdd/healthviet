<?php


namespace Healthviet\Banner\Model;

use Magento\Framework\Api\DataObjectHelper;
use Healthviet\Banner\Api\Data\BannerInterfaceFactory;
use Healthviet\Banner\Api\Data\BannerInterface;

class Banner extends \Magento\Framework\Model\AbstractModel
{

    protected $bannerDataFactory;

    protected $dataObjectHelper;

    protected $_eventPrefix = 'healthviet_banner_banner';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param BannerInterfaceFactory $bannerDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Healthviet\Banner\Model\ResourceModel\Banner $resource
     * @param \Healthviet\Banner\Model\ResourceModel\Banner\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        BannerInterfaceFactory $bannerDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Healthviet\Banner\Model\ResourceModel\Banner $resource,
        \Healthviet\Banner\Model\ResourceModel\Banner\Collection $resourceCollection,
        array $data = []
    ) {
        $this->bannerDataFactory = $bannerDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve banner model with banner data
     * @return BannerInterface
     */
    public function getDataModel()
    {
        $bannerData = $this->getData();

        $bannerDataObject = $this->bannerDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $bannerDataObject,
            $bannerData,
            BannerInterface::class
        );

        return $bannerDataObject;
    }
}
