<?php

namespace Healthviet\Sales\Plugin\Controller\AbstractController;

use Magento\Framework\App\Request\Http;

class OrderViewAuthorization
{
    private Http $request;

    public function __construct(
        Http $request
    ) {
        $this->request = $request;
    }

    public function afterCanView(
        \Magento\Sales\Controller\AbstractController\OrderViewAuthorization $subject,
        $result
    ) {
        $refererUrl =  $this->request->getServer('HTTP_REFERER');
        if (str_contains($refererUrl, 'admin/sales/order/view')) {
            $result = true;
        }

        return $result;
    }
}
