<?php

declare(strict_types=1);

namespace Healthviet\Shipping\Plugin\Magento\Checkout\Model;

use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Checkout\Model\ShippingInformationManagement as BaseShippingInformationManagement;
use Healthviet\Shipping\Model\Quote\Address\Updater as AddressUpdater;

class ShippingInformationManagement
{
    /**
     * @var AddressUpdater
     */
    protected $addressUpdater;

    /**
     * @param AddressUpdater $addressUpdater
     */
    public function __construct(
        AddressUpdater $addressUpdater
    ) {
        $this->addressUpdater = $addressUpdater;
    }

    /**
     * @param BaseShippingInformationManagement $subject
     * @param int $cartId
     * @param ShippingInformationInterface $addressInformation
     */
    public function beforeSaveAddressInformation(
        BaseShippingInformationManagement $subject,
        int $cartId,
        ShippingInformationInterface $addressInformation
    ): void {
        $shippingAddress = $addressInformation->getShippingAddress();
        $shippingAddressExtensionAttributes = $shippingAddress->getExtensionAttributes();

        if ($shippingAddressExtensionAttributes) {
            $this->addressUpdater->update($shippingAddress, $shippingAddressExtensionAttributes);
        }
    }
}
