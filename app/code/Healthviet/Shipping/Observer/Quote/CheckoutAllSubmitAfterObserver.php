<?php

declare(strict_types=1);

namespace Healthviet\Shipping\Observer\Quote;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address;
use Psr\Log\LoggerInterface;
use Healthviet\Shipping\Model\ResourceModel\CustomerAddress as CustomerAddressResource;

class CheckoutAllSubmitAfterObserver implements ObserverInterface
{
    /**
     * @var CustomerAddressResource
     */
    protected $customerAddressResource;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param CustomerAddressResource $customerAddressResource
     * @param LoggerInterface $logger
     */
    public function __construct(
        CustomerAddressResource $customerAddressResource,
        LoggerInterface $logger
    ) {
        $this->customerAddressResource = $customerAddressResource;
        $this->logger = $logger;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer): void
    {
        /** @var Quote $quote */
        $quote = $observer->getEvent()->getQuote();
        $quoteShippingAddress = $quote->getShippingAddress();
        $quoteBillingAddress = $quote->getBillingAddress();

        try {
            foreach ([$quoteShippingAddress, $quoteBillingAddress] as $quoteAddress) {
                if ($quoteAddress->getData('save_in_address_book') == 1
                    && $quoteAddress->getData('district_id')
                    && $quoteAddress->getData('ward_id')) {
                    $this->updateAddress($quoteAddress);
                }
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * @param Address $quoteAddress
     * @throws LocalizedException
     */
    protected function updateAddress(Address $quoteAddress): void
    {
        $data = [
            'district_id' => $quoteAddress->getData('district_id'),
            'district' => $quoteAddress->getData('district'),
            'ward_id' => $quoteAddress->getData('ward_id'),
            'ward' => $quoteAddress->getData('ward')
        ];

        $addressId = (int) $quoteAddress->getData('customer_address_id');
        $this->customerAddressResource->updateAddress($addressId, $data);
    }
}
