<?php

declare(strict_types=1);

namespace Healthviet\Shipping\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Healthviet\Directory\Model\ResourceModel\District\CollectionFactory as DistrictCollectionFactory;

class District implements OptionSourceInterface
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
        $propertyMap = [
            'value' => 'district_id',
            'title' => 'default_name',
            'label' => 'default_name',
            'region_id' => 'region_id',
        ];

        foreach ($this->districtCollection->create()->getItems() as $item) {
            $option = [];
            foreach ($propertyMap as $code => $field) {
                $option[$code] = $item->getData($field);
            }
            $options[] = $option;
        }

        if (count($options) > 0) {
            array_unshift(
                $options,
                ['title' => '', 'value' => '', 'label' => __('Please select a district.')]
            );
        }
        return $options;
    }
}
