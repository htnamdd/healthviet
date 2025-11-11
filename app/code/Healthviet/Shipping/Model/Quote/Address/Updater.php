<?php

declare(strict_types=1);

namespace Healthviet\Shipping\Model\Quote\Address;

use Magento\Quote\Api\Data\AddressExtensionInterface;
use Magento\Quote\Api\Data\AddressInterface;

class Updater
{
    /**
     * @param AddressInterface $address
     * @param AddressExtensionInterface $extensionAttributes
     */
    public function update(AddressInterface $address, AddressExtensionInterface $extensionAttributes): void
    {
        if (!$address->getCity()) {
            $address->setCity($address->getRegion());
        }

        $address->unsetData('ward');
        $address->unsetData('ward_id');
        $address->unsetData('district');
        $address->unsetData('district_id');

        $address->setDistrictId($extensionAttributes->getDistrictId());
        $address->setDistrict($extensionAttributes->getDistrict());
        $address->setWardId($extensionAttributes->getWardId());
        $address->setWard($extensionAttributes->getWard());
    }
}
