<?php

declare(strict_types=1);

namespace Healthviet\Shipping\Plugin\Magento\Quote\Model;

use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Model\BillingAddressManagement as BaseBillingAddressManagement;

class BillingAddressManagement
{
    /**
     * @param BaseBillingAddressManagement $subject
     * @param int $cartId
     * @param AddressInterface $address
     * @param false $useForShipping
     */
    public function beforeAssign(
        BaseBillingAddressManagement $subject,
        int $cartId,
        AddressInterface $address,
        $useForShipping = false
    ): void {
        $directoryAttributes = ['district_id', 'district', 'ward_id', 'ward'];
        $address->setCity($address->getRegion());

        foreach ($directoryAttributes as $directoryAttribute) {
            $data = $address->getData($directoryAttribute);
            if (is_array($data) && isset($data['value'])) {
                $address->unsetData($directoryAttribute);
                $address->setData($directoryAttribute, $data['value']);
            }
        }
    }
}
