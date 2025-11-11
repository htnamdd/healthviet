var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-shipping-information': {
                'Healthviet_Shipping/js/action/set-shipping-information-mixin': true
            },
            'Magento_Checkout/js/action/select-shipping-address': {
                'Healthviet_Shipping/js/action/select-shipping-address-mixin': true
            },
            'Magento_Checkout/js/action/set-billing-address': {
                'Healthviet_Shipping/js/action/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/action/select-billing-address': {
                'Healthviet_Shipping/js/action/select-billing-address-mixin': true
            },
            'Magento_Ui/js/lib/validation/validator': {
                'Healthviet_Shipping/js/validation-mixin': true
            }
        }
    }
};
