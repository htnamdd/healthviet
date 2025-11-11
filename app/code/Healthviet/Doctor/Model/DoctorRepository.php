<?php
declare(strict_types=1);

namespace Healthviet\Doctor\Model;

use Healthviet\Doctor\Api\Data\DoctorInterface;
use Healthviet\Doctor\Api\Data\DoctorInterfaceFactory;
use Healthviet\Doctor\Api\Data\DoctorSearchResultsInterfaceFactory;
use Healthviet\Doctor\Api\DoctorRepositoryInterface;
use Healthviet\Doctor\Model\ResourceModel\Doctor as ResourceDoctor;
use Healthviet\Doctor\Model\ResourceModel\Doctor\CollectionFactory as DoctorCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class DoctorRepository implements DoctorRepositoryInterface
{

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var DoctorCollectionFactory
     */
    protected $doctorCollectionFactory;

    /**
     * @var ResourceDoctor
     */
    protected $resource;

    /**
     * @var DoctorInterfaceFactory
     */
    protected $doctorFactory;

    /**
     * @var Doctor
     */
    protected $searchResultsFactory;


    /**
     * @param ResourceDoctor $resource
     * @param DoctorInterfaceFactory $doctorFactory
     * @param DoctorCollectionFactory $doctorCollectionFactory
     * @param DoctorSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceDoctor $resource,
        DoctorInterfaceFactory $doctorFactory,
        DoctorCollectionFactory $doctorCollectionFactory,
        DoctorSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->doctorFactory = $doctorFactory;
        $this->doctorCollectionFactory = $doctorCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(DoctorInterface $doctor)
    {
        try {
            $this->resource->save($doctor);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the doctor: %1',
                $exception->getMessage()
            ));
        }
        return $doctor;
    }

    /**
     * @inheritDoc
     */
    public function get($doctorId)
    {
        $doctor = $this->doctorFactory->create();
        $this->resource->load($doctor, $doctorId);
        if (!$doctor->getId()) {
            throw new NoSuchEntityException(__('Doctor with id "%1" does not exist.', $doctorId));
        }
        return $doctor;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->doctorCollectionFactory->create();
        
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
    public function delete(DoctorInterface $doctor)
    {
        try {
            $doctorModel = $this->doctorFactory->create();
            $this->resource->load($doctorModel, $doctor->getDoctorId());
            $this->resource->delete($doctorModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Doctor: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($doctorId)
    {
        return $this->delete($this->get($doctorId));
    }
}

