<?php

declare(strict_types=1);

namespace Healthviet\Customer\Model\Source;

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

        foreach ($this->wardCollection->create()->getItems() as $item) {
            $options[$item->getData('district_id')][] = [
                'value' => $item->getData('ward_id'),
                'label' => $item->getData('default_name'),
            ];
        }

        return $options;
    }
}
