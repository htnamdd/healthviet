<?php

declare(strict_types=1);

namespace Healthviet\Shipping\Model\Source;

use Healthviet\Directory\Model\ResourceModel\Ward\CollectionFactory as WardCollectionFactory;

class Ward
{
    /**
     * @var WardCollectionFactory
     */
    protected $wardCollection;

    /**
     * @param WardCollectionFactory $wardCollection
     */
    public function __construct(
        WardCollectionFactory $wardCollection
    ) {
        $this->wardCollection = $wardCollection;
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $options = [];
        $propertyMap = [
            'value' => 'ward_id',
            'title' => 'default_name',
            'label' => 'default_name',
            'district_id' => 'district_id',
        ];

        foreach ($this->wardCollection->create()->getItems() as $item) {
            $option = [];
            foreach ($propertyMap as $code => $field) {
                $option[$code] = $item->getData($field);
            }
            $options[] = $option;
        }

        if (count($options) > 0) {
            array_unshift(
                $options,
                ['title' => '', 'value' => '', 'label' => __('Please select a ward.')]
            );
        }
        return $options;
    }
}
