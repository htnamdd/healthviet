<?php


namespace Healthviet\Banner\Model\Source\Banner;


class TargetType implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => '_self', 'label' => __('Same Window')],
            ['value' => '_blank', 'label' => __('New Window Tab')]
        ];
    }
}
