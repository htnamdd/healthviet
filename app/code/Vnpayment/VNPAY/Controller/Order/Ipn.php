<?php

namespace Vnpayment\VNPAY\Controller\Order;

use Magento\Framework\App\Action\Context;
use Vnpayment\VNPAY\Helper\Helper;

class Ipn extends \Magento\Framework\App\Action\Action
{

    /** @var  \Magento\Sales\Model\Order */
    protected $order;

    /** @var  \Magento\Framework\App\Config\ScopeConfigInterface */
    protected $scopeConfig;

    protected Helper $helper;

    /**
     * Ipn constructor.
     * @param Context $context
     * @param \Magento\Sales\Model\Order $order
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context $context,
        \Magento\Sales\Model\Order $order,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        Helper $helper
    ) {
        parent::__construct($context);
        $this->order = $order;
        $this->scopeConfig = $scopeConfig;
        $this->helper = $helper;
    }

    /**
     * Order success action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $this->helper->writeLog('VNPAY IPN IP: ' . $_SERVER['REMOTE_ADDR']);
        $vnp_SecureHash = $this->getRequest()->getParam('vnp_SecureHash', '');
        $SECURE_SECRET = $this->scopeConfig->getValue('payment/vnpay/hash_code');
        $responseParams = $this->getRequest()->getParams();
        $this->helper->writeLog('VNPAY IPN response: ' . json_encode($responseParams));
        $inputData = [];
        foreach ($responseParams as $key => $value) {
            $inputData[$key] = $value;
        }
        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . $key . "=" . $value;
            } else {
                $hashData = $hashData . $key . "=" . $value;
                $i = 1;
            }
        }
        $returnData = [];
        $secureHash = hash_hmac('sha512', $hashData, $SECURE_SECRET);
        $vnpAmount = $inputData['vnp_Amount'] / 100;
        try {
            if ($secureHash == $vnp_SecureHash) {
                $vnp_TxnRef = $this->getRequest()->getParam('vnp_TxnRef', '000000000');
                $order = $this->order->loadByIncrementId($vnp_TxnRef);
                if ($order->getId()) {
                    if ($order->getGrandTotal() == $vnpAmount) {
                        if ($order->getStatus() != null && $order->getStatus() == 'pending') {
                            if ($inputData['vnp_ResponseCode'] == '00' && $inputData['vnp_TransactionStatus'] == '00') {
                                $this->helper->handlePaymentSuccess($order, $vnpAmount, $inputData);
                            }
                            $returnData['RspCode'] = '00';
                            $returnData['Message'] = 'Confirm Success';
                        } else {
                            $returnData['RspCode'] = '02';
                            $returnData['Message'] = 'Order already confirmed';
                        }
                    } else {
                        $returnData['RspCode'] = '04';
                        $returnData['Message'] = 'invalid amount';
                    }
                } else {
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Order not found';
                }
            } else {
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Chu ky khong hop le';
            }
        } catch (\Exception $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }
        //Trả lại VNPAY theo định dạng JSON
        $this->helper->writeLog('VNPAY IPN Data ' . json_encode($returnData));
        echo json_encode($returnData);
    }
}
