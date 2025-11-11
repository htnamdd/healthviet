<?php
declare(strict_types=1);

namespace Healthviet\CustomerFeedback\Model;

use Healthviet\CustomerFeedback\Api\CustomerFeedbackRepositoryInterface;
use Healthviet\CustomerFeedback\Api\Data\CustomerFeedbackInterface;
use Healthviet\CustomerFeedback\Api\Data\CustomerFeedbackInterfaceFactory;
use Healthviet\CustomerFeedback\Api\Data\CustomerFeedbackSearchResultsInterfaceFactory;
use Healthviet\CustomerFeedback\Model\ResourceModel\CustomerFeedback as ResourceCustomerFeedback;
use Healthviet\CustomerFeedback\Model\ResourceModel\CustomerFeedback\CollectionFactory as CustomerFeedbackCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class CustomerFeedbackRepository implements CustomerFeedbackRepositoryInterface
{

    /**
     * @var ResourceCustomerFeedback
     */
    protected $resource;

    /**
     * @var CustomerFeedbackCollectionFactory
     */
    protected $customerFeedbackCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var CustomerFeedback
     */
    protected $searchResultsFactory;

    /**
     * @var CustomerFeedbackInterfaceFactory
     */
    protected $customerFeedbackFactory;


    /**
     * @param ResourceCustomerFeedback $resource
     * @param CustomerFeedbackInterfaceFactory $customerFeedbackFactory
     * @param CustomerFeedbackCollectionFactory $customerFeedbackCollectionFactory
     * @param CustomerFeedbackSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceCustomerFeedback $resource,
        CustomerFeedbackInterfaceFactory $customerFeedbackFactory,
        CustomerFeedbackCollectionFactory $customerFeedbackCollectionFactory,
        CustomerFeedbackSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->customerFeedbackFactory = $customerFeedbackFactory;
        $this->customerFeedbackCollectionFactory = $customerFeedbackCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(
        CustomerFeedbackInterface $customerFeedback
    ) {
        try {
            $this->resource->save($customerFeedback);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the customerFeedback: %1',
                $exception->getMessage()
            ));
        }
        return $customerFeedback;
    }

    /**
     * @inheritDoc
     */
    public function get($customerFeedbackId)
    {
        $customerFeedback = $this->customerFeedbackFactory->create();
        $this->resource->load($customerFeedback, $customerFeedbackId);
        if (!$customerFeedback->getId()) {
            throw new NoSuchEntityException(__('CustomerFeedback with id "%1" does not exist.', $customerFeedbackId));
        }
        return $customerFeedback;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->customerFeedbackCollectionFactory->create();
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(
        CustomerFeedbackInterface $customerFeedback
    ) {
        try {
            $customerFeedbackModel = $this->customerFeedbackFactory->create();
            $this->resource->load($customerFeedbackModel, $customerFeedback->getCustomerfeedbackId());
            $this->resource->delete($customerFeedbackModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the CustomerFeedback: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($customerFeedbackId)
    {
        return $this->delete($this->get($customerFeedbackId));
    }
}

