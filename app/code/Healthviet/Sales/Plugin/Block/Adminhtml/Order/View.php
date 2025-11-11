<?php

namespace Healthviet\Sales\Plugin\Block\Adminhtml\Order;

use Magento\Framework\Url;

class View
{
    /**
     * @var Url
     */
    protected Url $urlHelper;

    public function __construct(
        Url $urlHelper
    ) {
        $this->urlHelper = $urlHelper;
    }

    public function beforeSetLayout(\Magento\Sales\Block\Adminhtml\Order\View $subject)
    {
        $printOrder = $this->urlHelper->getUrl('sales/order/print/order_id/' . $subject->getOrderId());
        $subject->addButton(
            'print_order',
            [
                'label' => __('Print Order'),
                'onclick' => "window.open('" . $printOrder . "', '_blank')",
                'class' => 'print'
            ]
        );
        return null;
    }
}
