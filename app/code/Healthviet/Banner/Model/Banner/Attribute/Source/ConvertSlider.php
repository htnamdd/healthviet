<?php

namespace Healthviet\Banner\Model\Banner\Attribute\Source;

class ConvertSlider implements \Magento\Framework\Option\ArrayInterface
{
    protected $sliderCollection;

    public function __construct(
        \Healthviet\Banner\Model\ResourceModel\Slider\CollectionFactory $sliderCollection
    )
    {
        $this->sliderCollection = $sliderCollection;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $result = [];
        $collection = $this->sliderCollection->create();
        foreach ($collection as $slider) {
            $result[] = [
                'value' => $slider->getSliderId(),
                'label' => __($slider->getTitle())
            ];
        }
        return $result;
    }
}
