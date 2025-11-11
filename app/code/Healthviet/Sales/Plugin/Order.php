<?php

namespace Healthviet\Sales\Plugin;

class Order
{
    /**
     * @param \Magento\Sales\Model\Order $subject
     * @param $result
     * @return string
     */
    public function afterGetCustomerName(\Magento\Sales\Model\Order $subject, $result): string
    {
        if ($subject->getCustomerFirstname()) {
            $result = $subject->getCustomerLastname() . ' ' . $subject->getCustomerFirstname();
        }

        return $result;
    }
}
