<?php

namespace Healthviet\Checkout\Observer;

use Magento\Framework\App\Request\Http;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Page\Config;

class NoIndexFollow implements ObserverInterface
{
    /**
     * @var Http
     */
    protected Http $request;

    /**
     * @var Config
     */
    protected Config $layoutFactory;

    public function __construct(
        Http $request,
        Config $layoutFactory
    ) {
        $this->request = $request;
        $this->layoutFactory = $layoutFactory;
    }
    public function execute(Observer $observer)
    {
        $customerPage = [
            'customer_account_confirmation',
            'customer_account_create',
            'customer_account_createpassword',
            'customer_account_edit',
            'customer_account_forgotpassword',
            'customer_account_index',
            'customer_account_login',
            'customer_account_logoutsuccess',
            'customer_address_form',
            'customer_address_index'
        ];
        $checkoutPage = ['checkout_index_index'];
        $fullActionName = $observer->getFullActionName();
        if (in_array($fullActionName, array_merge($customerPage, $checkoutPage))) {
            $this->layoutFactory->setRobots('NOINDEX,NOFOLLOW');
        }
    }
}
