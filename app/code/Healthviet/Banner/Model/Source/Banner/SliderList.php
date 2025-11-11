<?php

namespace Healthviet\Banner\Model\Source\Banner;

class SliderList extends \Healthviet\Banner\Model\Source\Banner\SliderCode
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $result = [];
        $collection=$this->getCollection();
        foreach ($collection as $slider) {
            $result[] = [
                'value' => $slider->getSliderId(),
                'label' => __($slider->getTitle())
            ];
        }
        return $result;
    }
}
