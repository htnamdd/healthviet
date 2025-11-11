<?php

declare(strict_types=1);

namespace Healthviet\Customer\Model\Source;

use Healthviet\Directory\Model\ResourceModel\District\CollectionFactory as DistrictCollectionFactory;

class District
{
    /**
     * @var DistrictCollectionFactory
     */
    protected $districtCollection;

    /**
     * @param DistrictCollectionFactory $districtCollection
     */
    public function __construct(
        DistrictCollectionFactory $districtCollection
    ) {
        $this->districtCollection = $districtCollection;
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $options = [];

        foreach ($this->districtCollection->create()->getItems() as $item) {
            $options[$item->getData('region_id')][] = [
                'value' => $item->getData('district_id'),
                'label' => $item->getData('default_name'),
            ];
        }

        return $options;
    }
}
