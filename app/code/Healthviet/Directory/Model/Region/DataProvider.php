<?php
declare(strict_types=1);

namespace Healthviet\Directory\Model\Region;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Healthviet\Directory\Model\ResourceModel\Region\Collection;
use Healthviet\Directory\Model\ResourceModel\Region\CollectionFactory;

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
     * @param CollectionFactory $regionCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $regionCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $regionCollectionFactory->create();
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

        foreach ($items as $region) {
            $this->loadedData[$region->getId()] = $region->getData();
        }

        $data = $this->dataPersistor->get('region');

        if (!empty($data)) {
            $region = $this->collection->getNewEmptyItem();
            $region->setData($data);
            $this->loadedData[$region->getId()] = $region->getData();
            $this->dataPersistor->clear('region');
        }

        return $this->loadedData;
    }
}
