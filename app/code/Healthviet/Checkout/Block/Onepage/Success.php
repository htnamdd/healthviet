<?php
namespace Healthviet\Checkout\Block\Onepage;

use Magento\Checkout\Block\Onepage\Success as OriginalSuccess;

class Success extends OriginalSuccess
{
    /**
     * Prepares block data
     *
     * @return void
     */
    protected function prepareBlockData()
    {
        parent::prepareBlockData();

        $order = $this->_checkoutSession->getLastRealOrder();
        $payment = $order->getPayment();

        $this->addData([
            'is_bank_transfer' => $payment->getMethod() == 'banktransfer'
        ]);
    }
}
