<?php

namespace Healthviet\Common\Model\Attribute\Source;

class ConvertBoolean implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray() {
        return [
            ['value' => 0, 'label' => __('No')],
            ['value' => 1, 'label' => __('Yes')]
        ];
    }
}
