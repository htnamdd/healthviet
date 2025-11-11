<?php
/**
 * Created by PhpStorm.
 * User: quanbh
 * Date: 03/01/2019
 * Time: 10:31
 */

namespace Healthviet\Banner\Model\Banner\Attribute\Source;

class ConvertBoolean implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray() {
        return [
            ['value' => 0, 'label' => __('No')],
            ['value' => 1, 'label' => __('Yes')]
        ];
    }
}
