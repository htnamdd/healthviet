<?php

namespace Healthviet\Customer\Plugin;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Helper\View as CustomerViewHelper;

class CustomerViewPlugin
{
    public function afterGetCustomerName(CustomerViewHelper $subject, $result, CustomerInterface $customerData)
    {
        return $customerData->getLastname() . ' ' . $customerData->getFirstname();
    }
}
