<?php
declare(strict_types=1);

namespace Healthviet\Directory\Model\Source\Directory;

use Magento\Framework\Option\ArrayInterface;
use Magento\Directory\Model\ResourceModel\Region\CollectionFactory;

class Region implements ArrayInterface
{
    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $regionCollection;

    /**
     * @param CollectionFactory $regionCollection
     */
    public function __construct(CollectionFactory $regionCollection)
    {
        $this->regionCollection = $regionCollection;
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $result = [];

        $collection = $this->regionCollection->create();
        $collection->addFieldToFilter('country_id', ['eq' => 'VN']);

        foreach ($collection as $region) {
            array_push($result,[
               'label' => $region->getDefaultName(),
               'value' => $region->getId()
            ]);
        }

        return $result;
    }

}
