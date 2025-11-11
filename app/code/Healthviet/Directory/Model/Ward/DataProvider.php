<?php
declare(strict_types=1);

namespace Healthviet\Directory\Model\Ward;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Healthviet\Directory\Model\ResourceModel\Ward\Collection;
use Healthviet\Directory\Model\ResourceModel\Ward\CollectionFactory;

class DataProvider extends ModifierPoolDataProvider
{
    /**
     * @var Collection
     */
    protected  $collection;

    /**
     * @var DataPersistorInterface
     */
    protected DataPersistorInterface $dataPersistor;

    /**
     * @var array
     */
    protected array $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $WardCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $WardCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $WardCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $this->loadedData = [];

        $items = $this->collection->getItems();

        foreach ($items as $ward) {
            $this->loadedData[$ward->getId()] = $ward->getData();
        }

        $data = $this->dataPersistor->get('ward');

        if (!empty($data)) {
            $Ward = $this->collection->getNewEmptyItem();
            $Ward->setData($data);
            $this->loadedData[$ward->getId()] = $ward->getData();
            $this->dataPersistor->clear('ward');
        }

        return $this->loadedData;
    }
}
