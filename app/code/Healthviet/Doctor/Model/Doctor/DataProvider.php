<?php
declare(strict_types=1);

namespace Healthviet\Doctor\Model\Doctor;

use Healthviet\Common\Helper\Data;
use Healthviet\Doctor\Model\ResourceModel\Doctor\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{

    /**
     * @var array
     */
    protected $loadedData;
    /**
     * @inheritDoc
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var string
     */
    protected $mediaUrl;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->mediaUrl = Data::getMediaUrl();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        foreach ($items as $model) {
            $id = $model->getId();
            $this->loadedData[$id] = $model->getData();
            $avatar = $model->getAvatar();
            if ($avatar) {
                $arrAvatar = explode('/', $avatar);
                $m['avatar'][0] = [
                    'name' => end($arrAvatar),
                    'url' => $this->mediaUrl . $avatar
                ];
                $this->loadedData[$id] = array_merge($this->loadedData[$id], $m);
            }
        }

        $data = $this->dataPersistor->get('healthviet_doctor_doctor');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('healthviet_doctor_doctor');
        }

        return $this->loadedData;
    }
}

