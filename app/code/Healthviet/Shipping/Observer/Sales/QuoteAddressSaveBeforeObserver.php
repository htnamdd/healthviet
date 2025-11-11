<?php

declare(strict_types=1);

namespace Healthviet\Shipping\Observer\Sales;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\Quote\Address;
use Healthviet\Shipping\Model\Quote\Address\Updater as AddressUpdater;

class QuoteAddressSaveBeforeObserver implements ObserverInterface
{
    /**
     * @var AddressUpdater
     */
    protected $addressUpdater;

    /**
     * @param AddressUpdater $addressUpdater
     * @param Config $config
     * @param Store $store
     */
    public function __construct(
        AddressUpdater $addressUpdater
    ) {
        $this->addressUpdater = $addressUpdater;
    }

    /**
     * @param Observer $observer
     * @return $this
     */
    public function execute(Observer $observer): self
    {
        /** @var Address $address */
        $address = $observer->getEvent()->getDataObject();
        $extensionAttributes = $address->getExtensionAttributes();

        if ($extensionAttributes && $address->getAddressType() == Address::ADDRESS_TYPE_BILLING) {
            $this->addressUpdater->update($address, $extensionAttributes);
        }

        return $this;
    }
}
