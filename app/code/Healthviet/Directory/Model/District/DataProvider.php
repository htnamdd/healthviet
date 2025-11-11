<?php
declare(strict_types=1);

namespace Healthviet\Directory\Model\District;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Healthviet\Directory\Model\ResourceModel\District\Collection;
use Healthviet\Directory\Model\ResourceModel\District\CollectionFactory;

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
     * @param CollectionFactory $districtCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $districtCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $districtCollectionFactory->create();
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

        foreach ($items as $district) {
            $this->loadedData[$district->getId()] = $district->getData();
        }

        $data = $this->dataPersistor->get('district');

        if (!empty($data)) {
            $district = $this->collection->getNewEmptyItem();
            $district->setData($data);
            $this->loadedData[$district->getId()] = $district->getData();
            $this->dataPersistor->clear('district');
        }

        return $this->loadedData;
    }
}
