<?php

namespace Vnpayment\VNPAY\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\DB\Transaction;
use Magento\Sales\Model\Order\Email\Sender\InvoiceSender;
use Magento\Sales\Model\Service\InvoiceService;
use Psr\Log\LoggerInterface;

class Helper extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var InvoiceService
     */
    private InvoiceService $invoiceService;

    /**
     * @var InvoiceSender
     */
    private InvoiceSender $invoiceSender;

    /**
     * @var Transaction
     */
    private Transaction $transaction;

    public function __construct(
        Context $context,
        LoggerInterface $logger,
        InvoiceService $invoiceService,
        InvoiceSender $invoiceSender,
        Transaction $transaction,
    ) {
        parent::__construct($context);
        $this->logger = $logger;
        $this->invoiceService = $invoiceService;
        $this->invoiceSender = $invoiceSender;
        $this->transaction = $transaction;
    }

    public function writeLog($message)
    {
        try {
            $writer = new \Zend_Log_Writer_Stream(BP . "/var/log/vnpay.log");
            $logger = new \Zend_Log();
            $logger->addWriter($writer);
            $logger->info($message);
        } catch (\Zend_Log_Exception $exception) {
            $this->logger->info('Write log error: ' . $exception->getMessage());
        }
    }

    /**
     * @param $order
     * @param $amount
     * @param $inputData
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function handlePaymentSuccess($order, $amount, $inputData)
    {
        $payment = $order->getPayment();
        $order->setTotalPaid(floatval($amount));
        $payment->setCcTransId($inputData['vnp_TransactionNo']);
        $payment->setTransactionId($inputData['vnp_TransactionNo']);
        $payment->setLastTransId($inputData['vnp_TransactionNo']);
        $order->save();
        if ($order->canInvoice()) {
            $this->createInvoice($order, $inputData['vnp_TransactionNo']);
        }
    }

    /**
     * @param $order
     * @param $transactionNo
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function createInvoice($order, $transactionNo)
    {
        $invoice = $this->invoiceService->prepareInvoice($order);
        $invoice->register();
        $invoice->getOrder()->setIsInProcess(true);
        $invoice->save();
        $transactionSave = $this->transaction->addObject(
            $invoice
        )->addObject(
            $invoice->getOrder()
        );
        $transactionSave->save();
        $this->invoiceSender->send($invoice);
        //Send Invoice mail to customer
        $order->addStatusHistoryComment(
            __('Notified customer about invoice creation #%1. Payment Id From VNPAY: %2', $invoice->getId(), $transactionNo)
        )
            ->setIsCustomerNotified(true)
            ->save();
    }
}
