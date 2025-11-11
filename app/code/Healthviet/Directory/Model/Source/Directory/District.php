<?php
declare(strict_types=1);

namespace Healthviet\Directory\Model\Source\Directory;

use Magento\Framework\Option\ArrayInterface;
use Healthviet\Directory\Model\ResourceModel\District\CollectionFactory;

class District implements ArrayInterface
{
    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $districtCollection;

    /**
     * @param CollectionFactory $districtCollection
     */
    public function __construct(CollectionFactory $districtCollection)
    {
        $this->districtCollection = $districtCollection;
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $result = [];

        $collection = $this->districtCollection->create();
        $collection->getSelect()->join(
            ['region' => $collection->getTable('directory_country_region')],
            'region.region_id = main_table.region_id',
            ['country_id', 'default_name as region_name']
        );
        $collection->addFieldToFilter('country_id', ['eq' => 'VN']);

        foreach ($collection as $district) {
            $districtData = ['label' => $district->getDefaultName(), 'value' => $district->getId()];
            $regionId = $district['region_id'];

            if (!isset($result[$regionId])) {
                $result[$regionId] = [
                    'label' => $district['region_name'],
                    'is_active' => 1,
                    'value' => [],
                    'optgroup' => []
                ];
            }

            array_push($result[$regionId]['optgroup'], $districtData);
            array_push($result[$regionId]['value'], $districtData);
        }

        return $result;
    }

}
