<?php


namespace Healthviet\Banner\Model;

use Healthviet\Banner\Model\ResourceModel\Slider as ResourceSlider;
use Magento\Framework\Api\DataObjectHelper;
use Healthviet\Banner\Api\Data\SliderSearchResultsInterfaceFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Healthviet\Banner\Api\Data\SliderInterfaceFactory;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Healthviet\Banner\Model\ResourceModel\Slider\CollectionFactory as SliderCollectionFactory;
use Healthviet\Banner\Api\SliderRepositoryInterface;

class SliderRepository implements SliderRepositoryInterface
{

    private $storeManager;

    protected $extensibleDataObjectConverter;
    protected $sliderFactory;

    protected $dataObjectProcessor;

    private $collectionProcessor;

    protected $resource;

    protected $sliderCollectionFactory;

    protected $dataSliderFactory;

    protected $searchResultsFactory;

    protected $dataObjectHelper;

    protected $extensionAttributesJoinProcessor;


    /**
     * @param ResourceSlider $resource
     * @param SliderFactory $sliderFactory
     * @param SliderInterfaceFactory $dataSliderFactory
     * @param SliderCollectionFactory $sliderCollectionFactory
     * @param SliderSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceSlider $resource,
        SliderFactory $sliderFactory,
        SliderInterfaceFactory $dataSliderFactory,
        SliderCollectionFactory $sliderCollectionFactory,
        SliderSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->sliderFactory = $sliderFactory;
        $this->sliderCollectionFactory = $sliderCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataSliderFactory = $dataSliderFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Healthviet\Banner\Api\Data\SliderInterface $slider
    ) {
        /* if (empty($slider->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $slider->setStoreId($storeId);
        } */

        $sliderData = $this->extensibleDataObjectConverter->toNestedArray(
            $slider,
            [],
            \Healthviet\Banner\Api\Data\SliderInterface::class
        );

        $sliderModel = $this->sliderFactory->create()->setData($sliderData);

        try {
            $this->resource->save($sliderModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the slider: %1',
                $exception->getMessage()
            ));
        }
        return $sliderModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getById($sliderId)
    {
        $slider = $this->sliderFactory->create();
        $this->resource->load($slider, $sliderId);
        if (!$slider->getId()) {
            throw new NoSuchEntityException(__('Slider with id "%1" does not exist.', $sliderId));
        }
        return $slider->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->sliderCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Healthviet\Banner\Api\Data\SliderInterface::class
        );

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Healthviet\Banner\Api\Data\SliderInterface $slider
    ) {
        try {
            $sliderModel = $this->sliderFactory->create();
            $this->resource->load($sliderModel, $slider->getSliderId());
            $this->resource->delete($sliderModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Slider: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($sliderId)
    {
        return $this->delete($this->getById($sliderId));
    }
}
