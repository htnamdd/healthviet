<?php

declare(strict_types=1);

namespace Healthviet\Shipping\Plugin\Magento\Sales\Api;

use Magento\Sales\Api\Data\OrderAddressExtensionInterfaceFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface as BaseOrderRepositoryInterface;

class OrderRepositoryInterface
{
    /**
     * @var OrderAddressExtensionInterfaceFactory
     */
    protected $addressExtensionFactory;

    /**
     * @param OrderAddressExtensionInterfaceFactory $addressExtensionFactory
     */
    public function __construct(
        OrderAddressExtensionInterfaceFactory $addressExtensionFactory
    ) {
        $this->addressExtensionFactory = $addressExtensionFactory;
    }

    /**
     * @param BaseOrderRepositoryInterface $subject
     * @param OrderSearchResultInterface $result
     * @return OrderSearchResultInterface
     */
    public function afterGetList(
        BaseOrderRepositoryInterface $subject,
        OrderSearchResultInterface $result
    ): OrderSearchResultInterface {
        foreach ($result->getItems() as $order) {
            $this->addAddressInfo($order);
        }

        return $result;
    }

    /**
     * @param BaseOrderRepositoryInterface $subject
     * @param OrderInterface $order
     * @return OrderInterface
     */
    public function afterGet(BaseOrderRepositoryInterface $subject, OrderInterface $order): OrderInterface
    {
        $this->addAddressInfo($order);
        return $order;
    }

    /**
     * @param OrderInterface $order
     */
    protected function addAddressInfo(OrderInterface $order): void
    {
        if (!$order->getIsVirtual()) {
            $shippingAssignments = $order->getExtensionAttributes()->getShippingAssignments();
            if (!$shippingAssignments) {
                return;
            }

            $shippingAddress = $order->getShippingAddress();
            foreach ($shippingAssignments as $shippingAssignment) {
                $address = $shippingAssignment->getShipping()->getAddress();
                $addressExtensionAttributes = $address->getExtensionAttributes() ?: $this->addressExtensionFactory->create();
                $addressExtensionAttributes->setWard($shippingAddress->getWard());
                $addressExtensionAttributes->setDistrict($shippingAddress->getDistrict());
                $address->setExtensionAttributes($addressExtensionAttributes);
            }
        }
    }
}
