<?php


namespace Vnpayment\VNPAY\Plugin;

class PaymentInformationManagementPlugin
{
    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $orderFactory;

    public function __construct(
        \Magento\Sales\Model\OrderFactory $orderFactory
    )
    {
        $this->orderFactory = $orderFactory;
    }

    public function afterSavePaymentInformationAndPlaceOrder(\Magento\Checkout\Model\PaymentInformationManagement $subject, $result)
    {
        $order = $this->orderFactory->create()->load($result);

        return $order->getIncrementId();
    }
}