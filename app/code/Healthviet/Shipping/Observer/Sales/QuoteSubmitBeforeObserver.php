<?php

declare(strict_types=1);

namespace Healthviet\Shipping\Observer\Sales;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address as QuoteAddress;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Model\Order\Address as OrderAddress;
use Psr\Log\LoggerInterface;

class QuoteSubmitBeforeObserver implements ObserverInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger,
    ) {
        $this->logger = $logger;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer): void
    {
        /** @var OrderInterface $order */
        $order = $observer->getEvent()->getOrder();

        /** @var Quote $quote */
        $quote = $observer->getEvent()->getQuote();

        try {
            if (!$quote->isVirtual()) {
                $quoteShippingAddress = $quote->getShippingAddress();
                $orderShippingAddress = $order->getShippingAddress();
                $this->setOrderAddress($quoteShippingAddress, $orderShippingAddress);
            }
            $quoteBillingAddress = $quote->getBillingAddress();
            $orderBillingAddress = $order->getBillingAddress();
            $this->setOrderAddress($quoteBillingAddress, $orderBillingAddress);
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
        }
    }

    /**
     * @param QuoteAddress $quoteAddress
     * @param OrderAddress $orderAddress
     */
    protected function setOrderAddress(QuoteAddress $quoteAddress, OrderAddress $orderAddress): void
    {
        if (!$orderAddress->getCity()) {
            $orderAddress->setCity($orderAddress->getRegion());
        }

        if ($quoteAddress->getDistrictId()) {
            $orderAddress->setDistrictId($quoteAddress->getDistrictId());
        }
        if ($quoteAddress->getDistrict()) {
            $orderAddress->setDistrict($quoteAddress->getDistrict());
        }
        if ($quoteAddress->getWardId()) {
            $orderAddress->setWardId($quoteAddress->getWardId());
        }
        if ($quoteAddress->getWard()) {
            $orderAddress->setWard($quoteAddress->getWard());
        }
    }
}
