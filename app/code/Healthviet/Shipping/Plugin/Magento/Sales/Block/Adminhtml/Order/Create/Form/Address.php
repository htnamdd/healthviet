<?php

declare(strict_types=1);

namespace Healthviet\Shipping\Plugin\Magento\Sales\Block\Adminhtml\Order\Create\Form;

use Magento\Framework\Data\Form;
use Magento\Sales\Block\Adminhtml\Order\Create\Form\Address as AddressForm;

class Address
{

    /**
     * @param AddressForm $subject
     * @param Form $result
     * @return Form
     */
    public function afterGetForm(AddressForm $subject, Form $result): Form
    {
        $districtIdElm = $result->getElement('district_id');
        if ($districtIdElm) {
            $districtIdElm->setNoDisplay(true);
        }

        $wardIdElm = $result->getElement('ward_id');
        if ($wardIdElm) {
            $wardIdElm->setNoDisplay(true);
        }

        $city = $result->getElement('city');
        if ($city) {
            $city->setReadonly(true);
        }

        return $result;
    }
}
